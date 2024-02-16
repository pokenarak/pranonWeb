<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('created_at')->paginate(12);
        return view('admin.news',compact('news'));
    }
    public function store(Request $request)
    {
        $path = '';
        if ($request->file('image')) {
            $path = $this->upload($request);
        }
        $news = new News();
        $news->topic = $request->topic;
        $news->detail = $request->detail;
        $news->image = 'images/'.$path;
        $news->user_id = Auth::id();
        $news->save();

        $this->Action($news->id,Action::$INSERT_ACTION);

        return redirect('/news')->with('success','เพิ่ม ข่าวประชาสัมพันธ์ เรียบร้อย');
    }
    public function upload(Request $request)
    {
        $file = $request->file('image');
        $file->hashName();
        $path = Storage::put('news',$file,'public');
        return $path;
    }
    public function update(Request $request)
    {
        $news = News::find($request->id);
        $path = $news->image;
        if ($request->file('image')) {
            Storage::delete($path);
            $path = $this->upload($request);
        }
        $news->topic = $request->topic;
        $news->detail = $request->detail;
        $news->image = 'images/'.$path;
        $news->user_id = Auth::id();
        $news->save();

        $this->Action($request->id,Action::$UPDATE_ACTION);

        return redirect('/news')->with('success','แก้ไข ข่าวประชาสัมพันธ์ เรียบร้อย');
    }
    public function destroy($id)
    {
        $news = News::find($id);
        if(Storage::directories($news->image)){
            Storage::delete($news->image);
        }
        $news->delete();

        $this->Action($id,Action::$DELETE_ACTION);

        return redirect('/news')->with('success','ลบ ข่าวประชาสัมพันธ์ เรียบร้อย');
    }
    static function Action($id_table,$act){
        $action = new Action();
        $action->id_table_action = $id_table;
        $action->user_id = Auth::id();
        $action->action = $act;
        $action->table_name = Action::$NEWS;
        $action->date = Carbon::now();
        $action->save();
    }
}
