<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Personnel;
use App\Models\RainsRetreat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
            $rainsRetreat =RainsRetreat::updateOrCreate (
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
        $m = RainsRetreat::where('year',$year)->whereHas('personnel',function (Builder $q){
            $q->whereNotNull('ordain_monk');
        })->get();

        $n = RainsRetreat::where('year',$year)->whereHas('personnel',function (Builder $q){
            $q->whereNull('ordain_monk');
            $q->whereNotNull('ordain_novice');
        })->get();
        $years = RainsRetreat::orderByDesc('year')->pluck('year')->unique();

        $persons = Personnel::where('active','1')->whereDoesntHave('rainsRetreat',function ($q) use($year){
            $q->where('year',$year);
        })->get();
        $monks = $persons->whereNotNull('ordain_monk')->sortBy('ordain_monk')->all();
        $novices = $persons->whereNull('ordain_monk')->whereNotNull('ordain_novice')->sortBy('birthday')->all();

        return view('admin.rainsRetreat',compact('years','m','n','monks','novices'));
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
