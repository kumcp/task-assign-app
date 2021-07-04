<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function list(){
        $skill = Skill::all();
        return view('site.skill.skill', compact('skill'));
    }
    public function store(Request $request) {
        $skill = new Skill();
        $skill->code = $request->project_type_code;
        $skill->name = $request->project_type_name;
        $skill->deadline = $request->project_type_deadline;
        $skill->common = $request->project_type_common;
        $skill->save();
        $request->session()->put('message', 'Đã thêm kỹ năng thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('skill.list');
    }
    public function edit($id) {
        $skill = Skill::findOrFail($id);
        $skills = Skill::all();
        return view('site.skill.skill-edit', compact('skill','skills'));
    }
    public function update(Request $request, $id) {
        $skill = Skill::findOrFail($id);
        $skill->code = $request->project_code;
        $skill->name = $request->project_name;
        $skill->save();
        $request->session()->put('message', 'Đã cập nhật kỹ năng thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('skill.list');
    }
    public function destroy($id) {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return redirect()->route('skill.list')->with('massage','Đã xóa kỹ năng thành công!');
    }
}
