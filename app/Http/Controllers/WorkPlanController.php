<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobAssign;
use App\Models\ProcessMethod;
use App\Models\WorkPlan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class WorkPlanController extends Controller
{

    const DEFAULT_PAGINATE = 15;

    
    public function create(Request $request, $jobId) 
    {

        
        $staffId = Auth::user()->staff_id;

        $job = Job::find($jobId);

        if ($job->assigner_id == $staffId) {
            return view('jobs.workplan', ['jobId' => $jobId]);
        }

        $jobAssign = JobAssign::where([
            'job_id' => $jobId,
            'staff_id' => $staffId
        ])
        ->with([
            'workPlans',
            'processMethod'
        ])
        ->first();



        $workPlans = $jobAssign ? $jobAssign->workPlans : [];

        
        return view('jobs.workplan-create', compact('jobId', 'workPlans'));
    }


    public function show($jobId, $assigneeId=null) {
        
        $condition = ['job_id'=> $jobId];

        if ($assigneeId) {
            $condition['staff_id'] = $assigneeId;
        }
        
        
        $jobAssigns = JobAssign::where($condition)->with([
            'job.assigner',
            'assignee',
            'workPlans',
            'processMethod'
        ])->get();

        return response()->json($jobAssigns);

    }


    public function store(Request $request)
    {


        $rules = [            
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'from_time' => ['required', 'date_format:H:i'],
            'to_time' => ['required', 'date_format:H:i'], 
            'content' => ['required', 'string', 'max:255'],
            'job_id' => 'required', 

        ];
        $messages = [
            'from_date.required' => 'Trường từ ngày là bắt buộc',
            'to_date.required' => 'Trường đến ngày là bắt buộc',
            'to_date.after_or_equal' => 'Trường đến ngày phải sau trường từ ngày',
            'from_time.required' => 'Trường từ giờ là bắt buộc',
            'to_time.required' => 'Trường đến giờ là bắt buộc',
            'to_time.after_or_equal' => 'Trường đến giờ phải sau trường từ giờ',
            'content.required' => 'Trường nội dung là bắt buộc',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->sometimes('to_time', 'after_or_equal:from_time', function($input) {
            return $input->from_date == $input->to_date;
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        


        try {

            // TODO get handling and related jobs
            $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);


            $jobId = $request->input('job_id');
            $staffId = Auth::user()->staff_id;

            $existingJobAssign = JobAssign::where([
                'job_id' => $jobId,
                'staff_id' => $staffId
            ])
            ->with([
                'job',
                'workPlans',
                'processMethod'
            ])
            ->first();

            $mainProcessMethod = ProcessMethod::where('name', 'chủ trì')->first();


            if ($existingJobAssign) {

                $existingJobAssign->workPlans()->create($request->all());

                if ($existingJobAssign->job->status != 'pending') {
                    return redirect()->route('workplans.create', ['jobId' => $jobId])->with('success', 'Thêm kế hoạch công việc thành công');
                }

                $existingJobAssign->update(['status' => 'active']);

                $processMethod = $existingJobAssign->processMethod;
                
                if ($processMethod->id == $mainProcessMethod->id) {
                    $existingJobAssign->job()->update(['status' => 'active']);
                }

                return view('jobs.job-detail', [
                    'jobs' => $jobs,
                    'jobId' => $jobId,
                    'success' => 'Nhận việc thành công'
                ]);


            }
            else {

                $newJobAssign = JobAssign::create([
                    'job_id' => $jobId,
                    'staff_id' => $staffId,
                    'process_method_id' => $mainProcessMethod->id,
                    'status' => 'accepted'
                ]);
                $newJobAssign->workPlans()->create($request->all());        
                
                $newJobAssign->job()->update(['status' => 'active']);

                
                return view('jobs.job-detail', [
                    'jobs' => $jobs,
                    'jobId' => $jobId,
                    'success' => 'Nhận việc thành công'
                ]);

            }




        } 
        catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['errorMessage', $e->getMessage()]);
        }
        



    }


    public function delete(Request $request) {
        
        if ($request->has('job_assign_id')) {
            $request->session()->put('job_assign_id', $request->input('job_assign_id'));
        }

        if (!$request->has('workplan_ids')) {

            return redirect()->back()->withInput()->withErrors(['workplan', 'Chưa chọn kế hoạch để xóa']);

        }


        $workPlanIds = $request->input('workplan_ids');

        try {

            WorkPlan::whereIn('id', $workPlanIds)->delete();

            return redirect()->back()->with('success', 'Xóa kế hoạch thực hiện thành công');
        
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['errorMessage', $e->getMessage()]);
        } 
            


    }
}
