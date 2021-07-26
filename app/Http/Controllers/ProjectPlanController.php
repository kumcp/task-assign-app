<?php

namespace App\Http\Controllers;
use App\Models\JobAssign;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectPlanController extends Controller
{
    public const DEFAULT_PAGINATE = 15;

    private function formatFeild($jobAssigns)
    {
        foreach ($jobAssigns as $jobAssign) {
            $jobAssign->phone = $jobAssign->staff->phone;
            $jobAssign->email = $jobAssign->staff->email;
            $jobAssign->deadline = $jobAssign->job->deadline;
            $jobAssign->name = $jobAssign->job->name;
            $jobAssign->name_oject = $jobAssign->staff->name;
            $jobAssign->delivery_volume = $jobAssign->job->assign_amount;
            $jobAssign->timesheet_volume = count($jobAssign->timeSheets);
            // TODO: chưa tính được % hoàn thành nên để fix cứng finish
            $jobAssign->finish = 'Loading... (%)';
        }
    }

    public function list(){
        $projects = Project::orderBy('name', 'ASC')->get();
        $jobAssigns = JobAssign::with(['job.project', 'staff', 'timeSheets'])
            ->orderBy('id', 'ASC')->paginate(self::DEFAULT_PAGINATE);
        $this->formatFeild($jobAssigns);
        return view('site.project-plan.project-plan', compact('jobAssigns','projects'));
    }

    public function search(Request $request){
        $projects = Project::orderBy('name', 'ASC')->get();
        $query = JobAssign::with(['job.project', 'staff', 'timeSheets']);
        if (isset($request->project_id)) {
            $query = $query->whereHas('job.project', function ($q) use($request) {
                $q->where('id', $request->project_id);
            });
        }
        $jobAssigns = $query->orderBy('id', 'ASC')->get();
        $this->formatFeild($jobAssigns);
        return view('site.project-plan.project-plan-search', compact('jobAssigns','projects'));
    }
}
