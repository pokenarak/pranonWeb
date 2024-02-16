<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Course;
use App\Models\Personnel;
use App\Models\Supject;
use App\Models\Teacter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index($year)
    {
        if ($year == 0) {
            $year = Course::select('year')->max('year');
        }
        $courses = Course::with('teacher','supject')->where('year' , $year)->orderBy('supject_id','ASC')->get();
        $years = Course::select('year')->orderBy('year','DESC')->groupBy('year')->get();

        $monks = Personnel::where('active','1')->whereNotNull('ordain_monk')->orderBy('ordain_monk','ASC');
        $novices = Personnel::where('active','1')->whereNotNull('ordain_novice')->whereNull('ordain_monk')->orderBy('birthday');
        $rawmans = Personnel::where('active','1')->whereNull('ordain_monk')->whereNull('ordain_novice')->orderBy('birthday');
        $persons = $monks->union($novices)->union($rawmans)->get();

        $supjects = Supject::all();

        return view('admin.course',compact('courses','years','year','persons','supjects'));
    }
    public function store(Request $request)
    {   $year = Carbon::now()->year;
        $course = Course::firstOrCreate(
            ['supject_id'=>$request->supject,'year'=>$year]
        );
        $teacher = new Teacter();
        $teacher->course_id = $course->id;;
        $teacher->personnel_id = $request->person;
        $teacher->detail = $request->detail;
        $teacher->save();

        $this->Action($teacher->id,Action::$INSERT_ACTION,Action::$TEACHER);

        return redirect()->route('course',['year'=>$year])->with('success','เพิ่ม รายวิชาและครูสอน เรียบร้อย');
    }
    public function update(Request $request)
    {
        $course = Course::find($request->id);
        $course->supject_id = $request->supject;
        $course->year = $request->year-543;
        $course->save();

        $this->Action($request->id,Action::$UPDATE_ACTION,Action::$COURSE);

        return redirect()->route('course',['year'=>'0'])->with('success','แก้ไข รายวิชา เรียบร้อย');
    }
    public function updateTeacher(Request $request)
    {
        $teacher = Teacter::find($request->id);
        $teacher->personnel_id = $request->person;
        $teacher->detail = $request->detail;
        $teacher->save();

        $this->Action($request->id,Action::$UPDATE_ACTION,Action::$TEACHER);

        return redirect()->route('course',['year'=>'0'])->with('success','แก้ไข ครูสอน เรียบร้อย');
    }
    public function destroy($id)
    {
        Teacter::where('course_id',$id)->delete();
        Course::destroy($id);

        $this->Action($id,Action::$DELETE_ACTION,Action::$COURSE);

        return redirect()->route('course',['year'=>'0'])->with('success','ลบ รายวิชา เรียบร้อย');
    }
    public function destroyTeacher($id)
    {
        Teacter::destroy($id);

        $this->Action($id,Action::$DELETE_ACTION,Action::$TEACHER);

        return redirect()->route('course',['year'=>'0'])->with('success','ลบ ครูสอน เรียบร้อย');
    }
    static function Action($id_table,$act,$table){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = $table;
        $action->date = Carbon::now();
        $action->save();
    }
}
