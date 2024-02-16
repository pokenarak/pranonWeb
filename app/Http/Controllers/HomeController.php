<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\News;
use App\Models\Pilgrimage;
use App\Models\Register;
use App\Models\Supject;


class HomeController extends Controller
{
    public function index()
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
        $pilgrimageInside = Pilgrimage::where('stage','ในประเทศ')->latest()->first();
        $pilgrimageOutside = Pilgrimage::where('stage','ต่างประเทศ')->latest()->first();

        return view('welcome',compact('news','activities','count','success','year','pilgrimageInside','pilgrimageOutside'));
    }
}
