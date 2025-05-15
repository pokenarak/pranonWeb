<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderByDesc('date')->paginate('12');
        return view('admin.video',compact('videos'));
    }

    public function store(Request $request)
    {
        $video = new Video();
        $video->link = $request->link;
        $video->date = Carbon::now();
        $video->save();

        $this->Action($video->id,Action::$INSERT_ACTION);
        return redirect()->route('video.index')->with('success','เพิ่ม วีดีทัศน์ เรียบร้อย');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        $this->Action($video->id,Action::$DELETE_ACTION);
        return redirect()->route('video.index')->with('success','ลบ วีดีทัศน์ เรียบร้อย');
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
