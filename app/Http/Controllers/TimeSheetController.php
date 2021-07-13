<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheetRequest;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\TimeSheet;
use Ramsey\Uuid\Type\Time;

const DEFAULT_PAGINATE = 15;

class TimeSheetController extends Controller
{
    public function insertData(TimeSheetRequest $request, $timeSheet){
        $timeSheet->from_date = $request->from_date;
        $timeSheet->to_date = $request->to_date;
        $timeSheet->form_time = $request->from_time;
        $timeSheet->to_time = $request->to_time;
        $timeSheet->content = $request->content;
        $timeSheet->save();
    }

    public function create(){
        $timeSheets = TimeSheet::orderBy('id', 'desc')->paginate(DEFAULT_PAGINATE);
        $nameJob = Job::all();
        $staff = Staff::all();
        return view('site.time-sheet.timesheet', compact('timeSheets', 'nameJob', 'staff'));
    }
    public function store(TimeSheetRequest $request){
        $timeSheet = new TimeSheet();
        $jobAssign = JobAssign::where('job_id','=', 8)->first();
        $timeSheet->job_assign_id = $jobAssign->id;
        $this->insertData($request, $timeSheet);
        return redirect()->route('timesheet.create')->with('success','Đã thêm timesheet thành công');
    }

    public function edit($id){
        $timeSheets = TimeSheet::orderBy('id', 'desc')->paginate(DEFAULT_PAGINATE);
        $job = TimeSheet::with('jobAssign')->findOrFail($id)->first();
        //dd($timeSheet->jobAssign->job->name);
        $timeSheet = TimeSheet::findOrFail($id);
        $nameJob = Job::all();
        $staff = Staff::all();
        return view('site.time-sheet.timesheet-edit', compact('job', 'timeSheets', 'staff', 'nameJob', 'timeSheet'));
    }

    public function update(TimeSheetRequest $request, $id){
        $timeSheet = TimeSheet::find($id);
        $this->insertData($request, $timeSheet);
        return redirect()->route('timesheet.create')->with('success','Đã sửa time sheet thành công');;
    }

    public function destroy($id) {
        $timeSheet = TimeSheet::findOrFail($id);
        $timeSheet->delete();
        return redirect()->route('timesheet.create')->with('success','Đã xóa time sheets thành công');
    }
}
