<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheetRequest;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\Staff;
use App\Models\TimeSheet;


class TimeSheetController extends Controller
{
    public const DEFAULT_PAGINATE = 15;

    private function insertData(TimeSheetRequest $request, $timeSheet){
        //TODO: Chưa có flow từ page jobAssign chuyển sang, nên hiện lấy id đầu tiên trong DB
        $jobAssignId = JobAssign::first()->id;
        $timeSheet->job_assign_id = $jobAssignId;
        $timeSheet->from_date = $request->from_date;
        $timeSheet->to_date = $request->to_date;
        $timeSheet->from_time = $request->from_time;
        $timeSheet->to_time = $request->to_time;
        $timeSheet->content = $request->content;
        $timeSheet->save();
    }

    public function create(){
        $timeSheets = TimeSheet::orderBy('id', 'desc')->paginate(self::DEFAULT_PAGINATE);
        $nameJobs = Job::orderBy('name', 'ASC')->get();
        $staffs = Staff::orderBy('name', 'ASC')->get();
        return view('site.time-sheet.timesheet', compact('timeSheets', 'nameJobs', 'staffs'));
    }

    public function store(TimeSheetRequest $request){
        $timeSheet = new TimeSheet();
        $this->insertData($request, $timeSheet);
        return redirect()->route('timesheet.create')->with('success','Đã thêm timesheet thành công');
    }

    public function edit($id){
        $timeSheets = TimeSheet::orderBy('id', 'DESC')->paginate(self::DEFAULT_PAGINATE);
        $job = TimeSheet::with('jobAssign')->findOrFail($id)->first();
        $timeSheet = TimeSheet::findOrFail($id);
        $nameJobs = Job::orderBy('id', 'DESC')->get();
        $staffs = Staff::orderBy('name', 'DESC')->get();
        return view('site.time-sheet.timesheet-edit', compact('job', 'timeSheets', 'staffs', 'nameJobs', 'timeSheet'));
    }

    public function update(TimeSheetRequest $request, $id){
        $timeSheet = TimeSheet::find($id);
        $this->insertData($request, $timeSheet);
        return redirect()->route('timesheet.create')->with('success','Đã sửa time sheet thành công');
    }

    public function destroy($id) {
        $timeSheet = TimeSheet::findOrFail($id);
        $timeSheet->delete();
        return redirect()->route('timesheet.create')->with('success','Đã xóa time sheets thành công');
    }
}
