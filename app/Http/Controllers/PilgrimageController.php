<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\pilgrimage;
use App\Models\stop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PilgrimageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pilgrimage = pilgrimage::orderByDesc('id')->paginate('20');
        return view('admin.pilgrimage.pilgrimage',compact('pilgrimage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pilgrimage.createPilgrimage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pilgrimage = new pilgrimage();
        $pilgrimage->name = $request->name;
        $pilgrimage->start = $request->start;
        $pilgrimage->end = $request->end;
        $pilgrimage->detail = $request->detail;
        $pilgrimage->stage = $request->stage;
        $pilgrimage->user_id = Auth::id();
        $pilgrimage->save();


        $allStop = $request->stop;
        $stopArray = explode('/',$allStop);
        for ($i=0; $i < count($stopArray)-1; $i++) {
            $flag = explode(',',$stopArray[$i]);
            $stop = new Stop();
            $stop->pilgrimage_id = $pilgrimage->id;
            $stop->no = $i+1;
            $stop->detail = $flag[0];
            $stop->date = $flag[1];
            $stop->save();
        }

        $this->Action($pilgrimage->id,Action::$INSERT_ACTION);

        return redirect()->route('pilgrimage.index')->with('success','เพิ่ม โครงการ เรียบร้อย');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stops = stop::where('id',$id)->first();
        $pilgrimage = pilgrimage::find($stops->pilgrimage_id);
        return view('user.showPilgrimage',compact('stops','pilgrimage'));
    }
    public function display()
    {
        $pilgrimage = pilgrimage::orderByDesc('id')->paginate('20');
        return view('user.pilgrimage',compact('pilgrimage'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pilgrimage = pilgrimage::with('stop')->where('id', $id)->first();
        return view('admin.pilgrimage.editPilgrimage',compact('pilgrimage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pilgrimage = pilgrimage::find($id);
        $pilgrimage->name = $request->name;
        $pilgrimage->start = $request->start;
        $pilgrimage->end = $request->end;
        $pilgrimage->detail = $request->detail;
        $pilgrimage->stage = $request->stage;
        $pilgrimage->user_id = Auth::id();
        $pilgrimage->save();

        // Stop::where('pilgrimage_id',$id)->delete();
        // $allStop = $request->stop;
        // $stopArray = explode('/',$allStop);
        // for ($i=0; $i < count($stopArray)-1; $i++) {
        //     $flag = explode(',',$stopArray[$i]);
        //     $stop = new Stop();
        //     $stop->pilgrimage_id = $pilgrimage->id;
        //     $stop->no = $i+1;
        //     $stop->detail = $flag[0];
        //     $stop->date = $flag[1];
        //     $stop->save();
        // }

        $this->Action($id,Action::$UPDATE_ACTION);

        return redirect()->route('pilgrimage.index')->with('success','แก้ไข โครงการ เรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        pilgrimage::destroy($id);
        $this->Action($id,Action::$DELETE_ACTION);
        return redirect()->route('pilgrimage.index')->with('success','ลบ โครงการ เรียบร้อย');
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
