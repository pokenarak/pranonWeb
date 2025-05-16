<?php

namespace App\Http\Controllers;

use App\Exports\RegisterExport;
use App\Models\Action;
use App\Models\Course;
use App\Models\Personnel;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index($year)
    {
        if ($year == 0) {
            $year = Course::select('year')->max('year');
        }
        $courses = Course::withCount([
            'register' => function(Builder $query){
                $query->whereNotNull('result');
            },
        ])->where('year' , $year)->orderBy('year','DESC')->orderBy('supject_id','ASC')->get();

        $personPali = Personnel::where('active','1')->whereDoesntHave('register',function ($q) use($year){
            $q->whereHas('course',function($query) use ($year){
                $query->where('year',$year);
                $query->whereHas('supject',function($qe){
                    $qe->where('type','บาลี');
                });
            });
        })->get();
        $personDhamma = Personnel::where('active','1')->whereDoesntHave('register',function ($q) use($year){
            $q->whereYear('date',$year);
            $q->whereHas('course',function($query){
                $query->whereHas('supject',function($qe){
                    $qe->where('type','นักธรรม');
                });
            });
        })->get();

        $monkPali = $personPali->whereNotNull('ordain_novice')->whereNotNull('ordain_monk')->sortBy('ordain_monk');
        $monkDhamma = $personDhamma->whereNotNull('ordain_novice')->whereNotNull('ordain_monk')->sortBy('ordain_monk');

        $novicePali = $personPali->whereNotNull('ordain_novice')->whereNull('ordain_monk')->sortBy('birthday');
        $noviceDhamma = $personDhamma->whereNotNull('ordain_novice')->whereNull('ordain_monk')->sortBy('birthday');

        $nunPali = $personPali->whereNull('ordain_novice')->whereNull('ordain_monk')->sortBy('birthday');
        $nunDhamma = $personDhamma->whereNull('ordain_novice')->whereNull('ordain_monk')->sortBy('birthday');
            
        $years = Course::select('year')->orderBy('year','DESC')->groupBy('year')->get();


        return view('admin.student',compact('courses','years','monkPali','monkDhamma','novicePali','noviceDhamma','nunPali','nunDhamma'));
    }
    public function exportPali($year,$type) 
    {
        return Excel::download(new RegisterExport($year,$type), $type.'.xlsx');
    }
    public function store(Request $request)
    {
        $students = $request->student;
        $id = $request->id;
        $year = Course::select('year')->where('id',$id)->first();
        $date = Carbon::now();
        foreach ($students as  $value) {
           Register::firstOrCreate(
               ['course_id' => $id,'personnel_id' => $value],
               ['date' => $date],
            );
        }
        $this->Action(0,Action::$INSERT_ACTION);
        return redirect()->route('student',['year'=>$year->year])->with('success','เพิ่ม นักเรียน เรียบร้อย');
    }
    public function update(Request $request)
    {
        $register = Register::find($request->id);
        $register->result = $request->result;
        $register->detail = $request->detail;
        $register->save();

        $this->Action($request->id,Action::$UPDATE_ACTION);

        return redirect()->route('student',['year'=>'0'])->with('success','แก้ไขข้อมูล นักเรียน เรียบร้อย');
    }
    public function destroyStudent(Request $request)
    {
       $students = $request->student;
       if ($students) {
            $id = $request->id;
            foreach ($students as  $value) {
                Register::where('course_id',$id)->where('personnel_id',$value)->delete();
            }
       }
       $year = Carbon::now()->year;
       $this->Action(0,Action::$DELETE_ACTION);
       return redirect()->route('student',['year'=>$year])->with('success','ลบข้อมูล นักเรียน เรียบร้อย');
    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$PILGRIMAGE;
        $action->date = Carbon::now();
        $action->save();
    }
}
