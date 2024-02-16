<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\pilgrimage;
use App\Models\stop;
use App\Models\stopImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StopImageController extends Controller
{
    public function edit($id)
    {

        $stop = stop::where('id',$id)->first();
        $pilgrimage = Pilgrimage::where('id',$stop->pilgrimage_id)->first();
        return view('admin.editStop',compact('stop','pilgrimage'));
    }
    public function update(Request $request, $id){

        $stop = stop::find($id);
        $stop->detail = $request->destination;
        $stop->date = $request->date;
        $stop->save();
        if($files = $request->file('image')){
            foreach ($files as $file) {
                $file->hashName();
                $path = Storage::put('stop/'.$id,$file,'public');
                $image = new stopImage();
                $image->stop_id = $stop->id;
                $image->path = 'images/'.$path;
                $image->save();
            }
        }
        if ($request->deleteImage) {
            $deleteImg = $request->deleteImage;
            foreach ($deleteImg as $value) {
                if ($value) {
                    $img = stopImage::find($value);
                    if(Storage::exists($img->path)){
                        Storage::delete($img->path);
                    }
                    $img->delete();
                }
            }
        }
        $this->Action($id,Action::$UPDATE_ACTION);
        return redirect()->back()->with('success','แก้ไข จุดหมาย เรียบร้อย');
    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$STOP_IMAGE;
        $action->date = Carbon::now();
        $action->save();
    }

}
