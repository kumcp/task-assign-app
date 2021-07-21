<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobAssign;
use App\Models\ProcessMethod;
use App\Models\WorkPlan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class WorkPlanController extends Controller
{
    
    public function create(Request $request) 
    {
        $jobAssignId = session('job_assign_id');

        $successMessage = $request->session()->get('success');
     
        if ($jobAssignId) {
            $workPlans = WorkPlan::where('job_assign_id', $jobAssignId)->orderBy('created_at', 'DESC')->get();
            
            if ($successMessage)
                return view('jobs.workplan-create', compact('jobAssignId', 'workPlans', 'successMessage'));
            
            return view('jobs.workplan-create', compact('jobAssignId', 'workPlans'));
            
        }
        
        $jobId = session('job_id') ? session('job_id') : $request->input('job_id');

        // TODO: get authenticated user id
        $staffId = session('staff_id') ? session('staff_id') : 10;

        $jobAssign = JobAssign::where([
            'job_id' => $jobId,
            'staff_id' => $staffId
        ])->with('workPlans')->first();


        if ($jobAssign && $jobAssign->workPlans->count()) {
            $jobAssignId = $jobAssign->id;
            $workPlans = $jobAssign->workPlans;
            return view('jobs.workplan-create', compact('jobAssignId', 'workPlans'));
        }
        
        
        return view('jobs.workplan-create', compact('jobId', 'staffId'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'from_time' => ['required', 'date_format:H:i'],
            'to_time' => ['required', 'date_format:H:i', 'after:from_time'], 
            'content' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
           
        }


        try {

            if ($request->has('job_assign_id')) {
                $jobAssignId = $request->input('job_assign_id');
            }
            else {
    
                $validator = Validator::make($request->all(), [
                    'job_id' => 'required', 
                    'staff_id' => 'required'
                ]);
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                   
                }
                $jobId = $request->input('job_id');
                $staffId = $request->input('staff_id');
    
    
                // TODO: get id of chu tri process method
                $mainProcessMethod = ProcessMethod::all()[0];
    
                $newJobAssign = JobAssign::create([
                    'job_id' => $jobId,
                    'staff_id' => $staffId,
                    'process_method_id' => $mainProcessMethod->id,
                    'status' => 'accepted'
                ]);
                
                $jobAssignId = $newJobAssign->id;
            }
    
    
            
            $workPlans = WorkPlan::where('job_assign_id', $jobAssignId)->get();
            
            $insertData = $request->has('job_assign_id') ? $request->all() : array_merge(['job_assign_id' => $jobAssignId], $request->all());
            WorkPlan::create($insertData);

            if (!$workPlans->count()) {
                
                $jobAssign = JobAssign::where('id', $jobAssignId)->with('job')->first();
    


                if ($jobAssign->status != 'accepted')
                    $jobAssign->update(['status' => 'accepted']);

                $job = $jobAssign->job;
                

                
                if ($job->status === 'pending') {

                    $job->update(['status' => 'active']);

                    // TODO get handling and related jobs
                    $jobs = Job::orderBy('created_at', 'DESC')->paginate(15);

                    return view('jobs.job-detail', [
                        'jobs' => $jobs,
                        'jobId' => $job->id,
                        'success' => 'Nhận việc thành công'
                    ]);

                }

                return redirect()->route('workplans.create')->with([
                    'job_assign_id' => $jobAssignId, 
                    'success' => 'Thêm kế hoạch công việc thành công'
                ]);

            }

            return redirect()->route('workplans.create')->with([
                'job_assign_id' => $jobAssignId, 
                'success' => 'Thêm kế hoạch công việc thành công'
            ]);
        } 
        catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['errorMessage', $e->getMessage()]);
        }
        



    }


    public function delete(Request $request) {
        
        if ($request->has('job_assign_id')) {
            $request->session()->put('job_assign_id', $request->input('job_assign_id'));
        }

        if ($request->has('workplan_ids')) {
            $workPlanIds = $request->input('workplan_ids');

            try {
                
                foreach($workPlanIds as $id) {
                    $workPlan = WorkPlan::find($id);
                    $workPlan->delete();
                }

                return redirect()->back()->with('success', 'Xóa kế hoạch thực hiện thành công');
            
            } catch (Exception $e) {
                return redirect()->back()->withInput()->withErrors(['errorMessage', $e->getMessage()]);
            } 
            

        }
        else {
            return redirect()->back()->withInput()->withErrors(['workplan', 'Chưa chọn kế hoạch để xóa']);
        }
    }
}
