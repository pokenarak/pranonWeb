<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Personnel;
use App\Models\RainsRetreat;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RainsRetreatController extends Controller
{
    public function store(Request $request)
    {
        $persons = $request->persons;
        $year = $request->year-543;
        $rainsRetreat = '';
        foreach ($persons as  $value) {
            $rainsRetreat =RainsRetreat::firstOrCreate(
                ['year' => $year,'personnel_id' => $value ]
            );
        }
         $this->Action(0,Action::$INSERT_ACTION);
        return redirect()->back()->with('success','เพิ่ม เรียบร้อย');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RainsRetreat  $rainsRetreat
     * @return \Illuminate\Http\Response
     */
    public function show($year)
    {
        $years = '';
        $rainsRetreat = RainsRetreat::where('year',$year)->orderByRaw('(select ordain_monk from personnels where personnels.id = rains_retreats.personnel_id)')->orderByRaw('(select birthday from personnels where personnels.id = rains_retreats.personnel_id)')->orderBy('id','asc')->paginate(30);

        $m =0;$n=0;
        foreach ($rainsRetreat as $value) {
            if($value->personnel->ordain_monk != ''){
                $m++;
            }else{
                $n++;
            }
        }
        $years = RainsRetreat::orderByDesc('year')->pluck('year')->unique();

        $persons = Personnel::all();
        $monks = $persons->whereNotNull('ordain_monk')->sortBy('ordain_monk')->all();
        $novices = $persons->whereNull('ordain_monk')->whereNotNull('ordain_novice')->sortBy('birthday')->all();

        return view('admin.rainsRetreat',compact('years','rainsRetreat','monks','novices','m','n'));
    }
    public function destroy(Request $request)
    {
        $persons = $request->persons;
        if ($persons) {
            foreach ($persons as $item) {
                $rainsRetreat = RainsRetreat::find($item);
                $rainsRetreat->delete();
            }
        }
        $this->Action(0,Action::$DELETE_ACTION);
        return redirect()->back()->with('success','ลบ เรียบร้อย');
    }

    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$RAINS_RETREAT;
        $action->date = Carbon::now();
        $action->save();
    }
}
