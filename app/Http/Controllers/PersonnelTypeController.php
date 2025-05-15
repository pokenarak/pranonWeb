<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\personnel_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonnelTypeController extends Controller
{
    public function index()
    {
        $type = personnel_type::orderBy('id','asc')->get();
        return view('admin.personneltype',compact('type'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required','unique:personnel_types'],
        ]);

        $type = new Personnel_type;
        $type -> name = $request->name;
        $type->save();

        $this->Action($type->id,Action::$INSERT_ACTION);

        return redirect('/personnelType')->with('success','เพิ่ม ประเภท เรียบร้อย');

    }
    public function update(Request $request)
    {
        $request->validate([
            'name'=> ['required','unique:personnel_types'],
        ]);
        $type = Personnel_type::find($request->id);
        $type->name = $request->name;
        $type->save();

        $this->Action($request->id,Action::$UPDATE_ACTION);

        return redirect('/personnelType')->with('success','แก้ไข ประเภท เรียบร้อย');
    }
    public function destroy($id)
    {
        Personnel_type::destroy($id);

        $this->Action($id,Action::$DELETE_ACTION);

        return redirect('/personnelType')->with('success','ลบ ประเภท เรียบร้อย');
    }

    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$PERSONNEL_TYPE;
        $action->date = Carbon::now();
        $action->save();
    }
}
