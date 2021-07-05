<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessMethodRequest;
use App\Models\ProcessMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProcessMethodController extends Controller
{
    public function list(){
        $process_methods = ProcessMethod::paginate(15);
        return view('site.process-method.process-method', compact('process_methods'));
    }
    public function store(ProcessMethodRequest $request) {
        dd('check');
        $process_method = new ProcessMethod();
        $process_method->code = $request->process_code;
        $process_method->name = $request->process_name;
        $process_method->assigner = $request->process_assigner;
        $process_method->save();
        $request->session()->put('message', 'Đã thêm hình thức xử lý thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('process-method.list');
    }
    public function edit($id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_methods = ProcessMethod::paginate(15);
        return view('site.process-method.process-method-edit', compact('process_method','process_methods'));
    }
    public function update(ProcessMethodRequest $request, $id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_method->code = $request->process_code;
        $process_method->name = $request->process_name;
        $process_method->assigner = $request->process_assigner;
        $process_method->save();
        $request->session()->put('message', 'Đã cập nhật hình thức xử lý thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('process-method.list');
    }
    public function destroy($id) {
        $process_method = ProcessMethod::findOrFail($id);
        $process_method->delete();
        return redirect()->route('process-method.list')->with('massage','Đã xóa hình thức xử lý thành công!');
    }
}
