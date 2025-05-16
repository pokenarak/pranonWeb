<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Personnel;
use App\Models\personnel_type;
use App\Models\Rank;
use App\Models\Register;
use App\Models\Supject;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class PersonnelController extends Controller
{

    public function index($type='monk')
    {
        $data = '';
        switch ($type) {
            case 'monk':
                $type = 'พระภิกษุ';

                $master = Personnel::where('active','1')->whereHas('type',function (Builder $query){
                    $query->whereIn('personnel_type_id',['1','2','3']);
                })->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get()->sortBy('type.personnel_type_id',SORT_REGULAR,false);
                $under = Personnel::where('active','1')->whereDoesntHave('type',function (Builder $query){
                    $query->whereIn('personnel_type_id',['1','2','3']);
                })->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
                $data = $master->merge($under);
                $data = collect($data)->paginate(20);
            break;
            case 'novice':
                $type = 'สามเณร';
                $data = Personnel::where('active','1')->whereNotNull('ordain_novice')->whereNull('ordain_monk')->orderBy('birthday')->paginate('20');
                break;
            case 'nun':
                $type = 'อุบาสกอุบาสิกา';
                $data = Personnel::where('active','1')->whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday')->paginate('20');
            break;
        }
        // $sortData = $data->getCollection()->sortByDesc('active');
        // $data->setCollection($sortData);
        $data->each(function($item){
            $item->name = $this->nameTitle($item->id,$item).$item->name;
        });
        return view('admin.person.index',compact('data','type'));
    }
    public function relocate(){
        $persons = Personnel::where('active','0')->paginate('20');
        return view('admin.person.relocate',compact('persons'));
    }
    public function show($id)
    {
        $person = Personnel::where('id',$id)->first();
        if($person->people_id){
            $person->people_id = Crypt::decryptString($person->people_id);
        }
        if($person->phone){
            $person->phone = Crypt::decryptString($person->phone);
        }
        $success = Register::with('course')->whereNotNull('result')->where('personnel_id',$id)->get()->sortBy('course.year');
        $supjects = Supject::all();
        $person->name = $this->nameTitle($person->id,$person).$person->name;
        $files='';
        if(Storage::directoryExists('person/'.$person->id)){
            $files=Storage::disk('public')->allFiles('person/'.$person->id);
        }
        
        return view('admin.person.show',compact('person','success','supjects','files'));
    }

    public function create()
    {
        $types = personnel_type::orderBy('id')->get();
        return view('admin.person.create',compact('types'));
    }
    public function store(Request $request)
    {
        $personnel = new Personnel();
        $personnel->name = $request->name;
        $personnel->lastname = $request->lastname;
        $personnel->ordianation_name = $request->ordianname;
        $personnel->people_id = Crypt::encryptString( $request->peopleId );
        $personnel->address = $request->address;
        $personnel->phone = Crypt::encryptString($request->tel);
        $personnel->birthday = $request->birthday;
        $personnel->ordain_novice = $request->noviceDate;
        $personnel->ordain_monk = $request->ordianDate;
        $personnel->old_temple_name = $request->oldTemple;
        $personnel->old_temple_tel = $request->oldTempleTel;
        $personnel->active = '1';
        $personnel->save();
        if ($request->file('image')) {
            $path = $this->upload($request,$personnel->id);
            $personnel->path = $path;
            $personnel->save();
        }
        $type ='nun';
        if($request->noviceDate){
            $type = 'novice';
        }
        if($request->ordianDate){
            $type = 'monk';
        }
        if($request->nunDate){
            $type = 'nun';
        }
        $this->Action($personnel->id,Action::$INSERT_ACTION);

        return Redirect()->route('person',['type'=>$type])->with('success','เพิ่ม บุคลากร เรียบร้อย');
    }
    public function upload(Request $request,$id)
    {
        $file = $request->file('image');
        $file->hashName();
        $path = Storage::put('person/'.$id,$file,'public');
        return 'images/'.$path;

    }
    public function edit($id)
    {
        $person = Personnel::where('id',$id)->first();
        $types = personnel_type::orderBy('id')->get();
        $person->people_id = Crypt::decryptString($person->people_id);
        $person->phone = Crypt::decryptString($person->phone);
        return view('admin.person.edit',compact('types','person'));
    }
    public function update(Request $request,$id)
    {
        $personnel = Personnel::find($id);
        if ($request->file('image')) {
            $path = $this->upload($request,$id);
            $personnel->path = $path;
        }
        $active = 0;
        if ($request->active) {
            $active = 1 ;
        }
        $personnel->name = $request->name;
        $personnel->lastname = $request->lastname;
        $personnel->ordianation_name = $request->ordianname;
        $personnel->people_id = Crypt::encryptString( $request->peopleId );
        $personnel->address = $request->address;
        $personnel->phone = Crypt::encryptString($request->tel);
        $personnel->birthday = $request->birthday;
        $personnel->ordain_novice = $request->noviceDate;
        $personnel->ordain_monk = $request->ordianDate;
        $personnel->old_temple_name = $request->oldTemple;
        $personnel->old_temple_tel = $request->oldTempleTel;
        $personnel->active = $active;
        $personnel->save();
        $type ='nun';
        if($request->noviceDate){
            $type = 'novice';
        }
        if($request->ordianDate){
            $type = 'monk';
        }
        if($request->nunDate){
            $type = 'nun';
        }
        $this->Action($id,Action::$UPDATE_ACTION);

        return redirect()->route('person',['type'=>$type])->with('success','แก้ไข บุคลากร เรียบร้อย');
    }
    public function destroy($id)
    {
        $personnel = Personnel::find($id);
        $path = $personnel->path;
        if ($path) {
            Storage::deleteDirectory('person/'.$id);
        }
        Personnel::destroy($id);
        $type ='monk';
        if($personnel->ordian_novice){
            $type = 'novice';
        }
        if($personnel->ordian_monk){
            $type = 'monk';
        }
        if($personnel->ordian_nun){
            $type = 'nun';
        }
        $this->Action($id,Action::$DELETE_ACTION);

        return redirect()->route('person',['type'=>$type])->with('success','ลบ บุคลากร เรียบร้อย');
    }

    public function deleteImage($id,$path)
    {

        Storage::delete('person/'.$id."/".$path);

        return redirect()->back()->with('success','ลบ รูปภาพเรียบร้อย เรียบร้อย');
    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$PERSONNEL;
        $action->date = Carbon::now();
        $action->save();
    }
    private function nameTitle($id,$person){
        $flag = Register::whereHas('course',function (Builder $q){
            $q->whereHas('supject',function (Builder $que){
                $que->where('name','like','%ป.ธ. ๓%');
            });
            $q->whereNotNull('result');
        })->where('personnel_id',$id)->get();
        $nameTitle ='คุณ';
        if(!$person->ordain_monk == ''){
            if(!$flag->isEmpty()){
                $nameTitle = "พระมหา";
            }else{
                $nameTitle = "พระ";
            }
        }else if(!$person->ordain_novice == ''){
            $nameTitle = "สามเณร";
        }
        return $nameTitle;
    }

}
