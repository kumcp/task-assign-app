<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSheet;
use App\Models\JobAssign;
use App\Models\Job;


class TimeSheetController extends Controller
{
    public function create(){
        $timeSheets = TimeSheet::paginate(10);
        return view('site.time-sheet.timesheet', compact('timeSheets'));
    }
    public function edit($id){
        $timeSheet = TimeSheet::findOrFail($id);
        $jobAssign = JobAssign::all();
        $jobs = Job::all();
        $timeSheets = TimeSheet::paginate(10);
        return view('site.time-sheet.timesheet-edit',
            compact('timeSheets', 'timeSheet', 'jobAssign', 'jobs'));
    }
}
