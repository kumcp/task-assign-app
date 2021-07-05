<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PriorityRequest;
use App\Models\Priority;

class PriorityController extends Controller
{
    public function list(){
        $prioritys = Priority::paginate(15);
        return view('site.priority.priority', compact('prioritys'));
    }
    public function store(PriorityRequest $request) {
        dd('check');
        $priority = new Priority();
        $priority->code = $request->priority_code;
        $priority->name = $request->priority_name;
        $priority->priority = $request->priority_number;
        $priority->save();
        $request->session()->put('message', 'Đã thêm độ ưu tiên thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('priority.list');
    }
    public function edit($id) {
        $priority = Priority::findOrFail($id);
        $prioritys = Priority::paginate(15);
        return view('site.priority.priority-edit', compact('priority','prioritys'));
    }
    public function update(PriorityRequest $request, $id) {
        $priority = Priority::findOrFail($id);
        $priority->code = $request->priority_code;
        $priority->name = $request->priority_name;
        $priority->priority = $request->priority_number;
        $priority->save();
        $request->session()->put('message', 'Đã cập nhật độ ưu tiên thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('priority.list');
    }
    public function destroy($id) {
        $priority = Priority::findOrFail($id);
        $priority->delete();
        return redirect()->route('priority.list')->with('massage','Đã xóa độ ưu tiên thành công!');
    }
}
