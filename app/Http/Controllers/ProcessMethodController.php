<?php

namespace App\Http\Controllers;

use App\Models\ProcessMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProcessMethodController extends Controller
{
    public function list(){
        $process_method = ProcessMethod::all();
        return view('site.process-method.process-method', compact('process_method'));
    }
    public function store(Request $request) {
        $process_method = new ProcessMethod();
        $process_method->code = $request->project_type_code;
        $process_method->name = $request->project_type_name;
        $process_method->deadline = $request->project_type_deadline;
        $process_method->common = $request->project_type_common;
        $process_method->save();
        $request->session()->put('message', 'Đã thêm loại công việc thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('process-method.list');
    }
    public function edit($id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_methods = ProcessMethod::all();
        return view('site.process-method.process-method-edit', compact('process_method','process_methods'));
    }
    public function update(Request $request, $id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_method->code = $request->project_code;
        $process_method->name = $request->project_name;
        $process_method->save();
        $request->session()->put('message', 'Đã cập nhật án thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('process-method.list');
    }
    public function destroy($id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_method->delete();
        return redirect()->route('process-method.list')->with('massage','Đã xóa dự án thành công!');
    }
}
