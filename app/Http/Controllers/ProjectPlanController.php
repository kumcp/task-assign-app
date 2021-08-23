<?php

namespace App\Http\Controllers;
use App\Models\JobAssign;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectPlanController extends Controller
{
    public const DEFAULT_PAGINATE = 15;

    private function formatFields($jobAssigns)
    {
        foreach ($jobAssigns as $jobAssign) {
            $jobAssign->phone = $jobAssign->assignee->account->phone;
            $jobAssign->email = $jobAssign->assignee->account->email;
            $jobAssign->deadline = $jobAssign->job->deadline;
            $jobAssign->name = $jobAssign->job->name;
            $jobAssign->name_oject = $jobAssign->assignee->name;
            $jobAssign->delivery_volume = $jobAssign->job->assign_amount ?? '?';

            $amountConfirms = $jobAssign->amountConfirms;
            $timeSheets = $jobAssign->timeSheets;
            if ($amountConfirms->count() > 0) {
                $jobAssign->timesheet_volume = $amountConfirms->sum('confirm_amount');
            }
            else {
                $totalTimeSheetAmount = 0;
    
                foreach ($timeSheets as $timeSheet) {
                    $totalTimeSheetAmount += $timeSheet->workAmountInManday();
                }
                $jobAssign->timesheet_volume = $totalTimeSheetAmount;
            }

            $jobAssign->finish = $jobAssign->job->assign_amount ? $jobAssign->timesheet_volume * 100 / $jobAssign->job->assign_amount : '?';
        }
    }

    public function list(){
        $projects = Project::orderBy('name', 'ASC')->get();
        $jobAssigns = JobAssign::with([
            'job.project', 
            'assignee.account',
            'amountConfirms', 
            'timeSheets'
        ])
        ->orderBy('id', 'ASC')
        ->paginate(self::DEFAULT_PAGINATE);
        $this->formatFields($jobAssigns);
        return view('site.project-plan.project-plan', compact('jobAssigns','projects'));
    }

    public function search(Request $request){
        $projects = Project::orderBy('name', 'ASC')->get();
        $query = JobAssign::with([
            'job.project',
            'assignee.account', 
            'amountConfirms',
            'timeSheets'
        ]);
        if (isset($request->project_id)) {
            $query = $query->whereHas('job.project', function ($q) use($request) {
                $q->where('id', $request->project_id);
            });
        }
        $jobAssigns = $query->orderBy('id', 'ASC')->get();
        $this->formatFields($jobAssigns);
        return view('site.project-plan.project-plan-search', compact('jobAssigns','projects'));
    }
}
