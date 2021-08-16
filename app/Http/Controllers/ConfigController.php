<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function updateField(Request $request, $field, $id){
        $config[$id] = Configuration::where('field',$field)->first();
        $config[$id]->value = $request->$field;
        $config[$id]->save();
    }
    public function list(){
        $config = Configuration::all();
        return view('site.config.configuration', compact('config'));
    }
    public function update(Request $request){
        $this->updateField($request, 'period', 0);
        $this->updateField($request, 'job_code', 1);
        $this->updateField($request, 'production_volume', 2);
        $this->updateField($request, 'volume_interface', 3);
        $this->updateField($request, 'get_job', 4);
        $this->updateField($request, 'Implementation_plan', 5);
        return redirect()->route('config.list')->with('success','Cập nhật cấu hình thành công');
    }

}