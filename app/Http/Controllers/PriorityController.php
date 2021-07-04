<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function list(){
        $priority = Priority::all();
        return view('site.priority.priority', compact('projects_type'));
    }
    public function store(Request $request) {
        $priority = new Priority();
        $priority->code = $request->project_type_code;
        $priority->name = $request->project_type_name;
        $priority->deadline = $request->project_type_deadline;
        $priority->common = $request->project_type_common;
        $priority->save();
        $request->session()->put('message', 'Đã thêm loại công việc thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('priority.list');
    }
    public function edit($id) {
        $priority = Priority::findOrFail($id);
        $prioritys = Priority::all();
        return view('site.priority.priority-edit', compact('priority','$prioritys'));
    }
    public function update(Request $request, $id) {
        $priority = Priority::findOrFail($id);
        $priority->code = $request->project_code;
        $priority->name = $request->project_name;
        $priority->save();
        $request->session()->put('message', 'Đã cập nhật án thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('priority.list');
    }
    public function destroy($id) {
        $priority = Priority::findOrFail($id);
        $priority->delete();
        return redirect()->route('priority.list')->with('massage','Đã xóa dự án thành công!');
    }
}
