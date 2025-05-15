<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calendars = Calendar::all()->paginate(20);
        return view('admin.calendar',compact('calendars'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($file = $request->file('file')) {
            $calendar = new Calendar();
            $file->hashName();
            $path = Storage::put('calendar',$file,'public');
            $calendar->path = $path;
            $calendar->year = $request->year;
            $calendar->save();
            $this->Action($calendar->id,Action::$INSERT_ACTION);
        }
        return redirect()->back()->with('success','เพิ่ม ปฏิทิน เรียบร้อย');
    }
    public function show(Calendar $calendar){
        return Storage::download($calendar->path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calendar $calendar)
    {
        $this->Action($calendar->id,Action::$DELETE_ACTION);
        $calendar->delete();
        return redirect()->back()->with('success','ลบ ปฏิทิน เรียบร้อย');

    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$ACTIVITY;
        $action->date = Carbon::now();
        $action->save();
    }
}
