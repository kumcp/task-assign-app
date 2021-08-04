<?php

namespace App\Http\Controllers;

use App\Models\StaffInfo;
use Exception;
use Illuminate\Http\Request;

class StaffInfoController extends Controller
{

    
    public function show($id) 
    {   
        $staffInfo = StaffInfo::where('staff_id', $id)->with('staff:id,name')->first();
        
        if (!$staffInfo)
            return back()->with('error', 'Không tồn tại nhân viên');
        
        $staffInfo->name = $staffInfo->staff->name;
        return view('staff-info', compact('staffInfo'));
    }



    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $staffInfo = StaffInfo::where('staff_id', $id)->with('staff')->first();
        
        try {
            $staffInfoUpdates = [
                'date_of_birth' => $request->has('dob') ? $request->dob : null,
                'gender' => $request->has('gender') ? $request->gender : null,
                'address' => $request->has('address') ? $request->address : null,
                'phone' => $request->has('phone') ? $request->phone : null,
            ];
            $staffInfo->update($staffInfoUpdates);
            
            $staffInfo->staff->update(['name' => $request->name]);
            return back()->with('success', 'Cập nhật thông tin thành công');
        } 
        catch (Exception $e) {
            return back()->withInput()->with('error', 'Đã có lỗi xảy ra!');
        }


        

    }
}
