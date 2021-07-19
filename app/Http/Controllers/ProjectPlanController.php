<?php

namespace App\Http\Controllers;

use App\Models\JobAssign;
use App\Models\Project;
use App\Models\TimeSheet;
use Illuminate\Http\Request;

class ProjectPlanController extends Controller
{
    public function list(){
        $jobAssigns = JobAssign::with('job', 'staff', 'timeSheets')
            ->orderBy('id', 'desc')->paginate(15);
        foreach ($jobAssigns as $jobAssign) {
            $jobAssign->phone =  $jobAssign->staff->phone;
            $jobAssign->email = $jobAssign->staff->email;
            $jobAssign->deadline = $jobAssign->job->deadline;
            $jobAssign->name = $jobAssign->job->name;
            $jobAssign->name_oject = $jobAssign->staff->name;
            $jobAssign->delivery_volume = $jobAssign->job->assign_amount;
            $jobAssign->timesheet_volume = 5;
            $jobAssign->finish = '50%';
        }
        $project = Project::all();
        return view('site.project-plan.project-plan', compact('jobAssigns','project'));
    }

    public function search(Request $request){
        $jobAssigns = JobAssign::with('job.project', 'staff', 'timeSheets')
            ->whereHas('job.project', function ($q) use($request) {
                $q->where('id', $request->project_id);
            })
            ->orderBy('id', 'desc')->paginate(15);

        foreach ($jobAssigns as $jobAssign) {
            $jobAssign->name_oject = $jobAssign->staff->name;
            $jobAssign->phone = $jobAssign->staff->phone;
            $jobAssign->email = $jobAssign->staff->email;
            $jobAssign->deadline = $jobAssign->job->deadline;
            $jobAssign->name = $jobAssign->job->name;
            $jobAssign->delivery_volume = $jobAssign->job->assign_amount;
            $jobAssign->timesheet_volume = 5;
            $jobAssign->finish = '50%';
        }

        $project = Project::all();
        return view('site.project-plan.project-plan', compact('jobAssigns','project'));
    }
}
