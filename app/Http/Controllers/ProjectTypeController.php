<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ProjectTypeRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectTypeRequest;

const DEFAULT_PAGINATE = 15;

class ProjectTypeController extends Controller
{
    public function insertData(ProjectTypeRequest $request, $projectsType){
        $projectsType->code = $request->project_type_code;
        $projectsType->name = $request->project_type_name;
        $projectsType->deadline = $request->project_type_deadline;
        $projectsType->common = $request->project_type_common;
        $projectsType->save();
    }
    public function list(){
<<<<<<< HEAD
        $projectsType = JobType::orderBy('id', 'desc')->paginate(DEFAULT_PAGINATE);
        return view('site.project-type.project-type', compact('projectsType'));
=======
        $projects_type = JobType::paginate(15);
        return view('site.project-type.project-type', compact('projects_type'));
>>>>>>> c845b81 (dat upcode)
    }
    public function store(ProjectTypeRequest $request) {
        $projectsType = new JobType();
        // check mã code trùng hay không?
        if (JobType::where('code', '=', $request->project_type_code)->exists()) {
            return redirect()->route('project-type.list')->with('success','Mã code đã tồn tại');
        }
        $this->insertData($request, $projectsType);
        return redirect()->route('project-type.list')->with('success','Đã thêm loại công việc thành công');
    }
    public function edit($id) {
<<<<<<< HEAD
        $projectType = JobType::findOrFail($id);
        $projectsType = JobType::orderBy('id', 'desc')->paginate(DEFAULT_PAGINATE);
        return view('site.project-type.project-type-edit', compact('projectType','projectsType'));
    }
    public function update(ProjectTypeRequest $request, $id) {
        $projectsType = JobType::findOrFail($id);
        // check mã code trùng hay không?
        if (JobType::where('code', '=', $request->project_type_code)->where('id', '!=', $id)->exists()) {
            return redirect()->route('project-type.edit', ['id' => $id])->with('success','Mã code đã tồn tại');
        }
        $this->insertData($request, $projectsType);
        return redirect()->route('project-type.list')->with('success','Đã cập nhật loại công việc thành công');
=======
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
>>>>>>> c845b81 (dat upcode)
    }
    public function destroy($id) {
        $projectType = JobType::findOrFail($id);
        $projectType->delete();
        return redirect()->route('project-type.list')->with('success','Đã xóa loại công việc thành công');
    }
}
