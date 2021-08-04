<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\ProcessMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobAssignController extends Controller
{
    const DEFAULT_PAGINATE = 15;

    public function index(Request $request) {
        $jobAssigns = [];

        if ($request->has('jobIds')) {
            $jobIds = $request->input('jobIds');

            $jobAssigns = JobAssign::whereIn('job_id', $jobIds)->with([
                'processMethod',
                'assignee'
            ])
            ->get();
            
        }

        return response()->json($jobAssigns);
    }
    
    public function updateStatus(Request $request)
    {
        $action = $request->input('action');
        $jobId = $request->input('job_id');
        $staffId = Auth::user()->staff_id;
        
        $job = Job::findOrFail($jobId);
        $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);

        $jobAssign = JobAssign::where([
            'job_id' => $jobId, 
            'staff_id' => $staffId
        ])->first();

        switch ($action) {
            case 'accept':
                
                $workPlanRequired = Configuration::where('field', 'workplan')->first('value')->value;
                
                if ($workPlanRequired == 'true') {
                    return redirect()->route('workplans.create', ['jobId' => $jobId]);
                }

                if ($jobAssign) {
                    $jobAssign->update(['status' => 'accepted']);
                }
                else {
                    $mainProcessMethod = ProcessMethod::where('name', 'chủ trì')->first();
                    JobAssign::create([
                        'job_id' => $jobId,
                        'staff_id' => $staffId,
                        'process_method_id' => $mainProcessMethod->id
                    ]);
                }

                $job->update(['status' => 'active']);

                

                return view('jobs.job-detail', [
                    'jobs' => $jobs,
                    'jobId' => $jobId,
                    'success' => 'Nhận việc thành công'
                ]);
                    



            case 'reject': 

                $denyReason = $request->input('deny_reason');

                if (!$denyReason)
                    return view('jobs.job-detail', [
                        'jobs' => $jobs,
                        'jobId' => $jobId,
                    ]);
                

                if ($jobAssign) {
                    $jobAssign->update([
                        'status' => 'rejected',
                        'deny_reason' => $denyReason
                    ]);
                }


                $job->update(['status' => 'rejected']);
                



                return view('jobs.job-detail', [
                    'jobs' => $jobs,
                    'jobId' => $jobId,
                    'success' => 'Từ chối công việc thành công'
                ]);

            case 'exchange': 
                //TODO: exchange function
                break;
        }
    }
}
