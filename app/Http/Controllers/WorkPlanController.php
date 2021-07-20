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
        // $jobAssignId = $request->session()->get('job_assign_id');
        $jobAssignId = session('job_assign_id');

        $successMessage = $request->session()->get('success');
     
        if ($jobAssignId) {
            $workPlans = WorkPlan::where('job_assign_id', $jobAssignId)->orderBy('created_at', 'DESC')->get();
            
            if ($successMessage)
                return view('jobs.workplan-create', compact('jobAssignId', 'workPlans', 'successMessage'));
            
            return view('jobs.workplan-create', compact('jobAssignId', 'workPlans'));
            
        }

        $staffId = session('staff_id');
        $jobId = session('job_id');
        
        return view('jobs.workplan-create', compact('jobId', 'staffId'));
    }


    public function store(Request $request)
    {

        if ($request->has('job_assign_id')) {
            $jobAssignId = $request->input('job_assign_id');
        }
        else {
            $jobId = $request->input('job_id');
            $staffId = $request->input('staff_id');
            
            $mainProcessMethod = ProcessMethod::where('name', 'chu-tri')->first();
            
            $newJobAssign = JobAssign::create([
                'job_id' => $jobId,
                'staff_id' => $staffId,
                'process_method_id' => $mainProcessMethod->id
            ]);
            
            $jobAssignId = $newJobAssign->id;
        }
        
        $workPlans = WorkPlan::where('job_assign_id', $jobAssignId)->get();

        $validator = Validator::make($request->all(), [
            'job_assign_id' => 'required', 
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'from_time' => ['required', 'date_format:H:i'],
            'to_time' => ['required', 'date_format:H:i', 'after:from_time'], 
            'content' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('job_assign_id', $jobAssignId);
           
        }

        try {
            WorkPlan::create($request->all());


           

            if (!$workPlans->count()) {
                $jobAssign = JobAssign::findOrFail($jobAssignId);
    
                $job = Job::with('jobAssigns')
                ->whereHas('jobAssigns', function($query) use ($jobAssignId){
                    $query->where('id', $jobAssignId);
                })->first();
                
                $jobStatus = $job->status;

                $job->update(['status' => 'active']);
                $jobAssign->update(['status' => 'accepted']);
                
                $jobs = Job::orderBy('created_at', 'DESC')->paginate(15);
                
                if ($jobStatus === 'pending')
                    return view('jobs.job-detail', [
                        'jobs' => $jobs,
                        'jobId' => $job->id,
                        'success' => 'Nhận việc thành công'
                    ]);

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
            return redirect()->back()->withInput()->withErrors(['errorMessage', $e->getMessage()])->with('job_assign_id', $jobAssignId);
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
