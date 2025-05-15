<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use Illuminate\Http\Request;

class RankController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rank = new Rank();
        $rank->name = $request->name;
        $rank->date = $request->date;
        $rank->personnel_id = $request->id;
        $rank->save();
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Rank::destroy($id);
        return redirect()->back()->with('success','ลบ เส้นทาง เรียบร้อย');
    }
}
