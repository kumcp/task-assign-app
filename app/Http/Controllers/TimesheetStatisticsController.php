<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Job;
use App\Models\Staff;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
const DEFAULT_PAGINATE = 15;
class TimesheetStatisticsController extends Controller
{
    /*
     *
     *
     */

    /**
     *  Show data time sheet statistics
     *
     */
    public function list(){
        $departments = Department::all();
        $staff = Staff::all();
        $timeStatistics = TimeSheet::with('jobAssign.job')
            ->with('jobAssign.staff')
            ->orderBy('id', 'desc')->paginate(100);
        foreach ($timeStatistics as $timeStatistic) {
            $timeStatistic->job_name =  $timeStatistic->jobAssign->job->name;
            $timeStatistic->object_handling = $timeStatistic->jobAssign->staff->name;
            $timeStatistic->finish = $timeStatistic->timeDate();
        }

        return view('site.timesheet-statistics.timesheet-statistics',
            compact('timeStatistics', 'departments', 'staff'));
    }

    public function search(Request $request){

        $timeStatistics = TimeSheet::with('jobAssign.job')
            ->with('jobAssign.staff')
            ->whereHas('jobAssign.staff', function ($q) use($request) {
                $q->where('department_id', $request->department)->where('id', $request->object_handling);
            })
            ->orderBy('id', 'desc')
            ->whereBetween('from_date', array($request->from_date, $request->to_date))

            ->get();
        foreach ($timeStatistics as $timeStatistic) {
            $timeStatistic->job_name =  $timeStatistic->jobAssign->job->name;
            $timeStatistic->object_handling = $timeStatistic->jobAssign->staff->name;
            $timeStatistic->finish = $timeStatistic->timeDate();
        }
        $jobs = Job::all();
        $departments = Department::all();
        $staff = Staff::all();

        return view('site.timesheet-statistics.timesheet-statistics-search',
            compact('timeStatistics', 'jobs', 'departments', 'staff'));
    }
}
