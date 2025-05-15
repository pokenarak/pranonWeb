<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Calendar;
use App\Models\Course;
use App\Models\Donation;
use App\Models\News;
use App\Models\Personnel;
use App\Models\pilgrimage;
use App\Models\RainsRetreat;
use App\Models\Register;
use App\Models\Supject;
use App\Models\Type;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDataController extends Controller
{
    public function welcome()
    {
        $video = Video::orderByDesc('date')->first();
        $news = News::orderByDesc('created_at')->limit(4)->get();
        $activities = Activity::with('image')->orderByDesc('date')->limit(6)->get();

        $count = Supject::withCount(['register' => function($query){
            $query->where('result','!=','');
        }])->get();
        $count = $count->groupBy('type')->map(function($row){
            return $row->sum('register_count');
        });
        $success = Register::with('course')->whereNotNull('result')->whereHas('course',function($query){
            $year = Course::whereHas('register',function (Builder $q){
                $q -> whereNotNull('result');
            })->max('year');
            return $query->where('year',$year);
        })->orderBy('course_id','asc')->get()->sortBy('course.supject_id');
        $year =Course::max('year')+543;
        $pilgrimageInside = pilgrimage::where('stage','ในประเทศ')->latest()->first();
        $pilgrimageOutside = pilgrimage::where('stage','ต่างประเทศ')->latest()->first();
        $donation = Donation::orderByDesc('date')->limit(4)->get();

        return view('welcome',compact('news','activities','count','success','year','pilgrimageInside','pilgrimageOutside','donation','video'));
    }

    public function userIndex($year,$type)
    {
        if($year == 0){
            $year = RainsRetreat::max('year');
        }
        $years = RainsRetreat::whereHas('personnel',function($query) use($type){
            switch ($type) {
                case 'monk':
                    $query->whereNotNull('ordain_monk');
                break;
                case 'novice':
                    $query->whereNotNull('ordain_novice')->whereNull('ordain_monk');
                break;
                case 'nun':
                    $query->whereNull('ordain_monk')->whereNull('ordain_novice');
                break;
            }
        })->orderByDesc('year')->pluck('year')->unique();
        $data = '';
        switch ($type) {
            case 'monk':
                $type = 'พระภิกษุ';

                $master = Personnel::with('type')
                ->whereHas('type',function (Builder $query){
                    $query->whereIn('personnel_type_id',['1','2','3']);
                })
                ->whereHas('rainsRetreat',function($query) use($year){
                    $query->where('year',$year);
                })->whereNotNull('ordain_monk')
                ->where('active','1')
                ->orderBy('ordain_monk','ASC')
                ->orderBy('birthday','asc')
                ->get();            
                
                $under = Personnel::whereDoesntHave('type',function (Builder $query){
                    $query->whereIn('personnel_type_id',['1','2','3']);
                })->where('active','1')->whereHas('rainsRetreat',function($query) use($year){
                    $query->where('year',$year);
                })->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
                $data = $master->concat($under);
                $data = collect($data)->paginate(20);
                
            break;
            case 'novice':
                $type = 'สามเณร';
                $data = Personnel::where('active','1')->whereHas('rainsRetreat',function($query) use($year){
                    $query->where('year',$year);
                })->whereNotNull('ordain_novice')->whereNull('ordain_monk')->orderBy('birthday')->paginate('20');
            break;
            case 'nun':
                $type = 'อุบาสกอุบาสิกา';
                $data = Personnel::where('active','1')->whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday')->paginate('20');
            break;
        }
        $data->each(function($item,$key){
            $item->name = $this->nameTitle($item->id,$item).$item->name;
        });
       
        return view('user.person',compact('data','years','type'));
    }

    public function activityIndex($year,$type)
    {
        $activities = '';
        if ($year == 0) {
            if ($type == 'all') {
                $activities = Activity::orderByDesc('date')->paginate('18');
            } else {
                $activities = Activity::where('type','การศึกษา')->orderByDesc('date')->paginate('18');
            }
            
        }else{
            if ($type == 'all') {
                $activities = Activity::whereYear('date',$year)->orderByDesc('date')->paginate('18');
            } else {
                $activities = Activity::whereYear('date',$year)->where('type','การศึกษา')->orderByDesc('date')->paginate('18');
            }
        }
        $years = Activity::select(DB::raw('year(date) as year'))->orderBy('year','DESC')->groupBy('year')->get();
        return view('user.activity',compact('years','activities'));
    }

    public function activityShow($id)
    {
        $activities = Activity::where('id',$id)->first();
        return view('user.showActivity',compact('activities'));
    }

    public function newsIndex(){
        $news = News::orderBy('created_at','desc')->paginate('20');
        return view('user.news',compact('news'));
    }
    public function newsInfo($id){

        $news = News::find($id);
        return view('user.showNews',compact('news'));
    }
    public function donation(){
        $donation = Donation::orderByDesc('date')->paginate('12');
        return view('user.donation',compact('donation'));
    }
    public function video(){
        $videos = Video::all()->paginate('12');
        return view('user.video',compact('videos'));
    }
    public function pali($year,$type){
        if ($year == 0) {
            $year = Course::select('year')->max('year');
        }
        $courses='';
        switch ($type) {
            case 'pali':
                $type = 'ประโยค';
                $courses = Course::with('teacher','supject')->whereHas('supject',function(Builder $query){
                    $query->where('name','like','%บาลี%');
                })->where('year' , $year)->orderBy('supject_id','ASC')->get();
            break;
            case 'dhamma':
                $type = 'ธรรม';
            break;
        }

        $flag = Course::with('teacher','supject')->whereHas('supject',function(Builder $query) use ($type){
            $query->where('name','like','%'.$type.'%');
        })->where('year' , $year)->orderBy('supject_id','ASC')->get();
        if($type=='ประโยค')
            $courses = $courses->concat($flag);
        else
            $courses = $flag;
        
        $years = Course::select('year')->orderBy('year','DESC')->groupBy('year')->get();

        $masters = Type::whereHas('personnel_type',function(Builder $query){
            $query->where('name','like','%สำนักเรียน%');
        })
        ->orderBy('personnel_type_id','asc')
        ->get();
        return view('user.course',compact('years','courses','masters'));
    }
    public function lv9(){
        $registers = Register::whereHas('course',function (Builder $q){
            $q ->whereHas('supject',function(Builder $query){
                $query->where('name','like','%๙%');
            });
        })
        ->whereNotNull('result')
        ->get();
        $registers = $registers->sortByDesc('course.year');
        return view('user.lv9',compact('registers'));
    }
    public function calendar(){
        $calendar = Calendar::orderByDesc('year')->first();
        if($calendar){
            $path = Storage::path($calendar->path);
             return response()->file($path);
        }else{
            return redirect('/');
        }
    }
    public function personInfo($id){
        $person = Personnel::where('id',$id)->first();

        $person->name = $this->nameTitle($id,$person).$person->name;
        
        return view('user.showPerson',compact('person'));
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
