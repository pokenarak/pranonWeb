<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Personnel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::withTrashed()->get();
        $persons = Personnel::all();
        return view('admin.admin',compact('admin','persons'));
    }

    public function store(Request $request)
    {
        $admin = new User();
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->name = $request->name;
        $admin->personnel_id = $request->personnel_id;
        $admin->role = $request->role;
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->save();

        $this->Action($admin->id,Action::$INSERT_ACTION);
        return redirect()->route('admin.index')->with('success','เพิ่ม ผู้ดูแลระบบ เรียบร้อย');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        User::where('id', $id)->withTrashed()->restore();
        return redirect()->back()->with('success','กู้คืน ผู้ดูแลระบบ เรียบร้อย');
    }

    public function destroy(string $id)
    {
        User::find($id)->delete();
        $this->Action($id,Action::$DELETE_ACTION);
        return redirect()->back()->with('success','ระงับการใช้งาน ผู้ดูแลระบบ เรียบร้อย');
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
