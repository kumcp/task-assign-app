<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ProjectTypeRequest;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function list(){
        $projects_type = JobType::paginate(15);
        return view('site.project-type.project-type', compact('projects_type'));
    }
    public function store(ProjectTypeRequest $request) {
        $projects_type = new JobType();
        $projects_type->code = $request->project_type_code;
        $projects_type->name = $request->project_type_name;
        $projects_type->deadline = $request->project_type_deadline;
        $projects_type->common = $request->project_type_common;
        $projects_type->save();
        $request->session()->put('message', 'Đã thêm loại công việc thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('project-type.list');
    }
    public function edit($id) {
        $project_type = JobType::findOrFail($id);
        $projects_type = JobType::paginate(15);
        return view('site.project-type.project-type-edit', compact('project_type','projects_type'));
    }
    public function update(ProjectTypeRequest $request, $id) {
        $projects_type = JobType::findOrFail($id);
        $projects_type->code = $request->project_type_code;
        $projects_type->name = $request->project_type_name;
        $projects_type->deadline = $request->project_type_deadline;
        $projects_type->common = $request->project_type_common;
        $projects_type->save();
        $request->session()->put('message', 'Đã cập nhật án thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('project-type.list');
    }
    public function destroy($id) {
        $projects_type = JobType::findOrFail($id);
        $projects_type->delete();
        return redirect()->route('project-type.list')->with('massage','Đã xóa dự án thành công!');
    }
}
