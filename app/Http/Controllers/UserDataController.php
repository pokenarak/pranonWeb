<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\News;
use App\Models\Personnel;
use App\Models\pilgrimage;
use App\Models\RainsRetreat;
use App\Models\Register;
use App\Models\Supject;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserDataController extends Controller
{
    public function welcome()
    {
        $news = News::orderByDesc('created_at')->limit(4)->get();
        $activities = Activity::with('image')->orderByDesc('date')->limit(6)->get();
        $count = Supject::withCount(['register' => function($query){
            $query->where('result','!=','');
        }])->get();
        $count = $count->groupBy('type')->map(function($row){
            return $row->sum('register_count');
        });
        $success = Register::whereNotNull('result')->whereHas('course',function($query){
            $year = Course::max('year');
            return $query->where('year',$year);
        })->orderBy('course_id','asc')->get();
        $year =Course::max('year')+543;
        $pilgrimageInside = pilgrimage::where('stage','ในประเทศ')->latest()->first();
        $pilgrimageOutside = pilgrimage::where('stage','ต่างประเทศ')->latest()->first();

        return view('welcome',compact('news','activities','count','success','year','pilgrimageInside','pilgrimageOutside'));
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
                $master = Personnel::whereHas('type')->where('active','1')->whereHas('rainsRetreat',function($query) use($year){
                    $query->where('year',$year);
                })->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
                $master = $master->sortBy(function($query){
                    return $query->type->min('personnel_type_id');
                });
                $under = Personnel::where('active','1')->whereHas('rainsRetreat',function($query) use($year){
                    $query->where('year',$year);
                })->whereDoesntHave('type')->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC')->orderBy('birthday','asc')->get();
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
                // $data = Personnel::where('active','1')->whereHas('type')->whereHas('rainsRetreat',function($query) use($year){
                //     $query->where('year',$year);
                // })->whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday')->get();
                $data = Personnel::where('active','1')->whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday')->paginate('20');
            break;
        }

        return view('user.person',compact('data','years','type'));
    }

    public function activityIndex($year)
    {
        $activities = '';
        if ($year == 0) {
            $activities = Activity::orderByDesc('date')->paginate('18');
        }else{
            $activities = Activity::whereYear('date',$year)->orderByDesc('date')->paginate('18');
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
        $news = News::paginate('20');
        return view('user.news',compact('news'));
    }
    public function newsInfo($id){

        $news = News::find($id);
        return view('user.showNews',compact('news'));
    }
}
