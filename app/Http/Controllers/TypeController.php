<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = new Type();
        $type->personnel_type_id =  $request->personnel_type_id;
        $type->date = $request->date;
        $type->personnel_id = $request->personnel_id;
        $type->save();
        return response()->json(['success'=>'Product saved successfully.']);
    }

    public function show(string $id)
    {
        Type::destroy($id);
        return redirect()->back()->with('success','ลบ เส้นทาง เรียบร้อย');
    }
}
