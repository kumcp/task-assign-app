<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobAssign;
use App\Models\ProcessMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssigneeListController extends Controller
{
    public function index(Request $request)
    {
        $jobs = [];

        $staffId = Auth::user()->staff_id;

        if ($request->has('jobIds')) {
            $jobIds = $request->input('jobIds');


            $jobs = Job::whereIn('id', $jobIds)->with('assigner')->get();

            if ($jobs->count() == 0) {
                return redirect()->back()->withErrors(['job_id' => 'Không tìm thấy công việc']);
            }
            
            foreach ($jobs as $job) {
                $job->assigner_name = $job->assigner->name;
            }



            if ($jobs[0]->assigner_id == $staffId) {
                $processMethods = ProcessMethod::whereNotIn('name', ['chuyển tiếp'])->get();
            }
            else {

                $jobAssign = JobAssign::where([
                    'job_id' => $job->id,
                    'staff_id' => $staffId
                ])
                ->with('processMethod')
                ->first();

                $processMethod = $jobAssign->processMethod;
                
                if ($processMethod->assigner) {

                    $processMethods = ProcessMethod::whereNotIn('name', [
                        $processMethod->name, 
                    ])->get();

                }
                else {

                    $processMethods = ProcessMethod::whereIn('name', [
                        $processMethod->name, 
                        'chuyển tiếp'
                    ])->get();

                }


            }
        }

        return view('jobs.assignee-list', compact('jobs', 'processMethods'));

    }


    public function show($jobId) {
        $job = Job::with([
            'assigner',
            'jobAssigns',
            'jobAssigns.processMethod',
            'jobAssigns.assignee',
        ])
        ->where('id', $jobId)
        ->first();

        $assigneeList = $this->reformat($job);

        return response()->json($assigneeList);

        
    }


    public function action(Request $request) 
    {

        $action = $request->input('action');

        if ($action == 'save') {
            if ($request->has('old_job_assigns')) {
            
                $oldJobAssignUpdates = array_map(function($jobAssign) {
                    return json_decode($jobAssign, true);
                }, $request->input('old_job_assigns'));
    
    
                foreach ($oldJobAssignUpdates as $update) {
                    
                    $jobAssignId = $update['id'];
    
                    $oldJobAssign = JobAssign::find($jobAssignId);
                    $oldJobAssign->update([
                        'sms' => $update['sms'],
                        'direct_report' => $update['direct_report'],
                        'deadline' => $update['deadline'],
                    ]);
                }
                
            }
    
            else {
                $rules = [
                    'job_assigns' => 'required',
                    'job_ids' => 'required',
                ];
        
                $messages = [
                    'job_assigns.required' => 'Chưa chọn đối tượng xử lý',
                    'job_ids.required' => 'Chưa chọn công việc nào'
                ];
        
                $validator = Validator::make($request->all(), $rules, $messages);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                }
            }
    
            if ($request->has('job_assigns')) {
    
                $jobAssigns = $request->input('job_assigns');
    
    
                $jobAssigns = array_map(function($item) {
                    return json_decode($item, true);
                }, $jobAssigns);
        
        
                $jobIds = $request->input('job_ids');
        
                $staffId = Auth::user()->staff_id;
        
        
        
                try{
        
                    $jobs = Job::whereIn('id', $jobIds)->with('jobAssigns')->get();
                    
                    if ($jobs->count() == 0) {
                        return redirect()->back()->withErrors(['job_ids', 'Không tìm thấy công việc nào']);
                    }
        
                    $forwardProcessMethod = ProcessMethod::where('name', 'chuyển tiếp')->first();
        
                    $forwardJobAssigns = array_filter($jobAssigns, function($jobAssign) use ($forwardProcessMethod) {
                        return $jobAssign['process_method_id'] == $forwardProcessMethod->id;
                    });
        
                    $otherJobAssigns = array_filter($jobAssigns, function($jobAssign) use ($forwardProcessMethod) {
                        return $jobAssign['process_method_id'] != $forwardProcessMethod->id;
                    });

        
             
        
        
                    foreach ($jobs as $job) {
                        
                        
        
                        if ($job->assigner_id == $staffId) {
                            
                            $job->jobAssigns()->createMany($otherJobAssigns);
        
                        }
                        else {
            
            
                            $currentJobAssign = JobAssign::where([
                                'job_id' => $job->id,
                                'staff_id' => $staffId
                            ])->first();
            
                            $mappedForwardJobAssigns = array_map(function($jobAssign) use ($currentJobAssign) {
                                
                                $jobAssign['parent_id'] = $currentJobAssign->id;
                                $jobAssign['process_method_id'] = $currentJobAssign->process_method_id;

                                return $jobAssign;
        
                            }, $forwardJobAssigns);
            
                            $mappedOtherJobAssigns = array_map(function($jobAssign) use ($currentJobAssign) {
                                
                                $jobAssign['parent_id'] = $currentJobAssign->id;
                                $jobAssign['is_additional'] = true;
                                
                                return $jobAssign;
        
                            }, $otherJobAssigns);
            
                            $newJobAssigns = array_merge($mappedForwardJobAssigns, $mappedOtherJobAssigns);
        

                            $job->jobAssigns()->createMany($newJobAssigns);
        
        
            
                        }
                    }
        
        
        
                    return redirect()->back()->with('success', 'Giao xử lý thành công');
        
                } catch (Exception $e) {
                    return redirect()->back()->with('error', 'Đã có lỗi xảy ra');
                }
    
    
            }
    
            return redirect()->back()->with('success', 'Giao xử lý thành công');
    
    
        }

        else {

            if (!$request->has('delete_ids')) {
                return redirect()->back()->withErrors(['delete_ids' => 'Chưa chọn đối tượng để xóa']);
            }

            $jobAssignIds = $request->input('delete_ids');

            try {

                JobAssign::whereIn('id', $jobAssignIds)->delete();
                return redirect()->back()->with('success', 'Xóa đối tượng xử lý thành công');

            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Đã có lỗi xảy ra');
            }

        }
        
        
    }



    private function reformat ($job) 
    {
        $reformat = [];

        $assigner = $job->assigner->name;
        $evaluator = null;

        foreach ($job->jobAssigns as $jobAssign) {
            $reformatObj = [
                'assigner' => $assigner,
                'evaluator' => $evaluator,
                'assignee' => $jobAssign->assignee->name,
                'process_method' => $jobAssign->processMethod->name,
                'history' => null,
                'status' => $jobAssign->status

            ];

            $reformat[] = $reformatObj;
        } 

        return $reformat;


    }
}
