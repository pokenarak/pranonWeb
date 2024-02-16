<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index($year)
    {
        $activities = '';
        if ($year == 0) {
            $activities = Activity::orderByDesc('date')->paginate('18');
        }else{
            $activities = Activity::whereYear('date',$year)->orderByDesc('date')->paginate('18');
        }
        $years = Activity::select(DB::raw('year(date) as year'))->orderBy('year','DESC')->groupBy('year')->get();
        return view('admin.activities.index',compact('years','activities'));
    }
    public function show($year)
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
    public function display($id)
    {
        $activities = Activity::where('id',$id)->first();
        return view('user.showActivity',compact('activities'));
    }
    public function store(Request $request)
    {
        $activity = new Activity();
        $activity->topic = $request->topic;
        $activity->detail = $request->detail;
        $activity->user_id = Auth::id();
        $activity->date = Carbon::now();
        $activity->save();
        if($request->file('image')){
            $this->uploadImage($request->file('image'),$activity->id);
        }
        $this->Action($activity->id,Action::$INSERT_ACTION);
        return redirect()->route('activity',['year'=>'0'])->with('success','เพิ่ม กิจกรรม เรียบร้อย');
    }
    function uploadImage($files,$id){
        foreach ($files as $file) {
            $file->hashName();
            $path = Storage::put('activities/'.$id,$file,'public');
            $image = new image();
            $image->activity_id = $id;
            $image->path = 'images/'.$path;
            $image->save();
        }
    }
    public function edit($id)
    {
        $activities = Activity::with('image')->where('id',$id)->get();
        return view('admin.activities.edit',compact('activities'));
    }
    public function update(Request $request)
    {
        $activity = Activity::find($request->id);
        $activity->topic = $request->topic;
        $activity->detail = $request->detail;
        $activity->user_id = Auth::id();
        $activity->date = $request->date;
        $activity->save();
        if($request->file('image')){
            $this->uploadImage($request->file('image'),$activity->id);
        }
        if ($request->deleteImage) {
            $deleteImg = $request->deleteImage;
            foreach ($deleteImg as $value) {
                if ($value) {
                    $img = image::find($value);
                    if(Storage::exists($img->path)){
                        Storage::delete($img->path);
                    }
                    $img->delete();
                }
            }
        }
        $this->Action($request->id,Action::$UPDATE_ACTION);
        return redirect()->route('editActivity',['id'=>$activity->id])->with('success','แก้ไข กิจกรรม เรียบร้อย');
    }
    public function destroy($id)
    {
        image::where('activity_id',$id)->delete();
        Activity::destroy($id);
        Storage::deleteDirectory('activities/'.$id);
        $this->Action($id,Action::$DELETE_ACTION);
        return redirect()->route('activity',['year'=>'0'])->with('success','ลบ กิจกรรม เรียบร้อย');
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
