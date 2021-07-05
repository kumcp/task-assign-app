<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillRequest;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function list(){
        $skills = Skill::paginate(15);
        return view('site.skill.skill', compact('skills'));
    }
    public function store(SkillRequest $request) {
        $skill = new Skill();
        $skill->code = $request->skill_code;
        $skill->name = $request->skill_name;
        $skill->save();
        $request->session()->put('message', 'Đã thêm kỹ năng thành công! ');
        $request->session()->put('messageType', 'success');
        return redirect()->route('skill.list');
    }
    public function edit($id) {
        $skill = Skill::findOrFail($id);
        $skills = Skill::paginate(15);
        return view('site.skill.skill-edit', compact('skill','skills'));
    }
    public function update(SkillRequest $request, $id) {
        $skill = Skill::findOrFail($id);
        $skill->code = $request->skill_code;
        $skill->name = $request->skill_name;
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
