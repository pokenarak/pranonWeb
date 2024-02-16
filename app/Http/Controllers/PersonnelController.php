<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Personnel;
use App\Models\personnel_type;
use App\Models\Rank;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PersonnelController extends Controller
{

    public function index($type='monk')
    {
        $data = '';
        switch ($type) {
            case 'monk':
                $type = 'พระภิกษุ';

                $master = Personnel::whereHas('type')->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
                $under = Personnel::whereDoesntHave('type')->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
                $data = $master->merge($under);
                $data = collect($data)->paginate(20);
            break;
            case 'novice':
                $type = 'สามเณร';
                $data = Personnel::whereNotNull('ordain_novice')->whereNull('ordain_monk')->orderBy('birthday')->paginate('20');
                break;
            case 'nun':
                $type = 'อุบาสกอุบาสิกา';
                $data = Personnel::whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday')->paginate('20');
            break;
        }
        $sortData = $data->getCollection()->sortByDesc('active');
        $data->setCollection($sortData);
        return view('admin.person.index',compact('data','type'));
    }
    public function show($id)
    {
        $person = Personnel::where('id',$id)->first();
        $person->people_id = Crypt::decryptString($person->people_id);
        $person->phone = Crypt::decryptString($person->phone);
        return view('admin.person.show',compact('person'));
    }

    public function create()
    {
        $types = personnel_type::orderBy('id')->get();
        return view('admin.person.create',compact('types'));
    }
    public function store(Request $request)
    {

        $path = '';
        if ($request->file('image')) {
            $path = $this->upload($request);
        }
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
        $personnel->ordain_nun = $request->nunDate;
        $personnel->old_temple_name = $request->oldTemple;
        $personnel->old_temple_tel = $request->oldTempleTel;
        $personnel->path = $path;
        $personnel->active = '1';
        $personnel->save();
        if($types = $request->typeChips){
            foreach ($types as $value) {
                $flag = explode(':',$value);
                $type = new Type();
                $type->personnel_type_id = $flag[0];
                $type->date = trim($flag[1]);
                $type->personnel_id = $personnel->id;
                $type->save();
            }
        }
        if($ranks = $request->rankChips){
            foreach ($ranks as $value) {
                $flag = explode(':',$value);
                $rank = new Rank();
                $rank->name = $flag[0];
                $rank->date = trim($flag[1]);
                $rank->personnel_id =  $personnel->id;
                $rank->save();
            }
        }
        $type ='monk';
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
    public function upload(Request $request)
    {
        $file = $request->file('image');
        $file->hashName();
        $path = Storage::put('person',$file,'public');
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
            if($path = $personnel->path){
                $cutPath = substr($path,8);
                Storage::delete($cutPath);
            }
            $path = $this->upload($request);
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
        $personnel->ordain_nun = $request->nunDate;
        $personnel->old_temple_name = $request->oldTemple;
        $personnel->old_temple_tel = $request->oldTempleTel;
        $personnel->active = $active;
        $personnel->save();
        if($types = $request->typeChips){
            Type::where('personnel_id',$personnel->id)->delete();
            foreach ($types as $value) {
                $flag = explode(':',$value);
                $type = new Type();
                $type->personnel_type_id = $flag[0];
                $type->date = trim($flag[1]);
                $type->personnel_id = $personnel->id;
                $type->save();
            }
        }
        if($ranks = $request->rankChips){
            Rank::where('personnel_id',$personnel->id)->delete();
            foreach ($ranks as $value) {
                $flag = explode(':',$value);
                $rank = new Rank();
                $rank->name = $flag[0];
                $rank->date = trim($flag[1]);
                $rank->personnel_id =  $personnel->id;
                $rank->save();
            }
        }
        $type ='monk';
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
            $cutPath = substr($path,8);
            Storage::delete($cutPath);
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

    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$PERSONNEL;
        $action->date = Carbon::now();
        $action->save();
    }

}
