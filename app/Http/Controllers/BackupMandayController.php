<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Job;
use App\Models\Project;
use Illuminate\Http\Request;

class BackupMandayController extends Controller
{
    public function list(){
        $departments = Department::all();
        $projects = Project::all();
        $jobs = Job::with('project')->orderBy('name', 'ASC')->paginate(10);
        foreach ($jobs as $job){
            $job->code = $job->project->code;
            $job->name_project = $job->project->name;
            $job->total_manday_lsx = $job->lsx_amount;
            $job->total_manday_assign = $job->assign_amount;
            // Manday du tru = Manday LSX - Manday giao
            $job->total_manday_reserve = ($job->lsx_amount) - ($job->assign_amount);
        }
        return view('site.backup-manday.backup-manday', compact('departments', 'projects', 'jobs'));
    }

    public function search(Request $request){
        $departments = Department::all();
        $projects = Project::all();

        $fromDate =  $request->from_date;
        $toDate = $request->to_date;

        if ($fromDate > $toDate){
            return redirect()->route('backup-maday.list')->with('success', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
        }

        if ($fromDate == NULL || $toDate == NULL){
            return redirect()->route('backup-maday.list')->with('success', 'Ngày bắt đầu hoặc ngày kết thúc không được để rỗng');
        }

        $jobs = Job::with(['project', 'jobAssigns.staff.department'])
            ->whereHas('project', function ($q) use($request) {
                $q->where('id', $request->project);
            })
            ->whereHas('jobAssigns.staff.department', function ($q) use($request) {
                $q->where('id', $request->department);
            })
            ->where('deadline', '>=', $fromDate)
            ->Where('created_at', '<=', $toDate)
            ->orderBy('name', 'ASC')->paginate(10);


        foreach ($jobs as $job){
            $job->code = $job->project->code;
            $job->name_project = $job->project->name;
            $job->total_manday_lsx = $job->lsx_amount;
            $job->total_manday_assign = $job->assign_amount;
            // Manday du tru = Manday LSX - Manday giao
            $job->total_manday_reserve = ($job->lsx_amount) - ($job->assign_amount);
        }
        return view('site.backup-manday.backup-manday-search', compact('departments', 'projects', 'jobs'));
    }
}
