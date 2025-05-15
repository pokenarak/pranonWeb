<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donation = Donation::orderByDesc('date')->paginate('12');
        return view('admin.donation',compact('donation'));
    }

    public function store(Request $request)
    {
        $donation = new Donation();
        $donation->name = $request->name;
        $donation->detail = $request->detail;
        $donation->date = $request->date;
        if($file = $request->file('file')){
            $file->hashName();
            $donation->path = Storage::put('donation/',$file,'public');
        }
        $donation->save();

        $this->Action($donation->id,Action::$INSERT_ACTION);
        return redirect()->route('donation.index')->with('success','เพิ่ม ผู้บริจาค เรียบร้อย');

    }

    public function update(Request $request, Donation $donation)
    {
        $donation->name = $request->name;
        $donation->detail = $request->detail;
        $donation->date = $request->date;
        if($file = $request->file('file')){
            $img = $donation->path;
                    if(Storage::exists($img)){
                        Storage::delete($img);
                    }
            $file->hashName();
            $donation->path = Storage::put('donation/',$file,'public');
        }
        $donation->save();
        $this->Action($donation->id,Action::$UPDATE_ACTION);
        return redirect()->route('donation.index',)->with('success','แก้ไข ผู้บริจาค เรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        $this->Action($donation->id,Action::$DELETE_ACTION);
        return redirect()->route('donation.index')->with('success','ลบ ผู้บริจาค เรียบร้อย');
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
