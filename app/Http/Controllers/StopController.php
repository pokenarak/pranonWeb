<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\stop;
use App\Models\stopImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StopController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->pilgrimage_id;
        $amount = stop::where('pilgrimage_id',$id)->get()->count();
        $stop = new stop();
        $stop->pilgrimage_id = $id;
        $stop->no = $amount+1;
        $stop->detail = $request->detail;
        $stop->date = $request->date;
        $stop->save();
        $this->Action($id,Action::$INSERT_ACTION);
        return redirect()->route('pilgrimage.edit',['pilgrimage'=>$id])->with('success','เพิ่ม เส้นทาง เรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        StopImage::where('stop_id',$id)->delete();
        $idPilgrimage = stop::find($id)->first();
        stop::destroy($id);
        $this->Action($id,Action::$DELETE_ACTION);
        return redirect()->back()->with('success','ลบ เส้นทาง เรียบร้อย');
    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$STOP;
        $action->date = Carbon::now();
        $action->save();
    }
}
