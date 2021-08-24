<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\File;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\JobType;
use App\Models\Priority;
use App\Models\ProcessMethod;
use App\Models\Project;
use App\Models\Staff;
use App\Models\UpdateJobHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;


class JobsController extends Controller
{
    const DEFAULT_PAGINATE = 15;
    const MAIN_ASSIGNEE = 1;

    public function index(Request $request)
    {



        $staffId = Auth::user()->staff_id;

        if ($request->has('type')) {
           
            $type = $request->input('type');

            
            $jobTypes = JobType::orderBy('name')->get();
            $assigners = Staff::orderBy('name')->get();
            $projects = Project::orderBy('name')->get();

            $condition = [];
            if ($request->method() === 'POST') {
                
                foreach ($request->all() as $key => $value) {
                    if (!in_array($key, ['_token', 'type', 'from_date', 'to_date']) && $value)
                        $condition[$key] = $value;
                    
                    if ($key == 'from_date' && $value) {
                        $condition[] = ['deadline', '>=' , $value];
                    }

                    if ($key == 'to_date' && $value) {
                        $condition[] = ['deadline', '<=', $value];
                    } 

                }
              
            }

            

            switch ($type) {

                case 'pending': 
                    [$newAssignedJobs, $unassignedJobs] = $this->getPendingJobs($staffId, $condition);
                    
                    $request->flash();


                    return view('jobs.pending-jobs', compact('newAssignedJobs', 'unassignedJobs', 'jobTypes', 'assigners', 'projects', 'type'));

                case 'handling': 
                    [$directJobs, $relatedJobs] = $this->getHandlingJobs($staffId, $condition);
                    
                    $request->flash();
                    
                    return view('jobs.handling-jobs', compact('directJobs', 'relatedJobs', 'jobTypes', 'assigners', 'projects', 'type'));
                
                case 'assigner': 
                    [$createdJobs, $forwardJobs] = $this->getAssignerJobs($staffId, $condition);
                    
                    $request->flash();
                    
                    return view('jobs.assigner-jobs', compact('createdJobs', 'forwardJobs', 'jobTypes', 'assigners', 'projects', 'type'));
            }

        }
        else {
            $jobs = $this->getAllJobsByStaffId($staffId);

            return view('jobs.all-jobs', compact('jobs'));
        }

    }

    public function show($id)
    {

        $job = Job::with([
            'parent', 
            'type', 
            'project', 
            'priority', 
            'assigner',
            'assignees',
            'jobAssigns.processMethod',
            'files',
        ])
        ->where('id', $id)
        ->first();

        $status = $job->status;

        $job->status = __('jobStatus.' . $status, [], 'vi');

        $assignees = $job->assignees;
        $jobAssigns = $job->jobAssigns;

        foreach($assignees as $assignee) {
            $id = $assignee->id;
            $processMethodId = $assignee->pivot->process_method_id;
            
            $jobAssign = array_filter($jobAssigns->toArray(), function($item) use ($id, $processMethodId){
                return ($item['staff_id'] == $id && $item['process_method_id'] == $processMethodId);
            });

            $jobAssign = array_values($jobAssign)[0];
            
        
            $assignee->pivot->process_method = $jobAssign['process_method']['name'];

        }

        $job->assignees = $assignees;


        return response($job);
    }

    public function create($jobId=null)
    {
        
        $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);
        $staff = Staff::all();
        $projects = Project::all();
        $jobTypes = JobType::all();
        $priorities = Priority::all();
        $processMethods = ProcessMethod::all();
    
        
        return view('jobs.create', compact('staff', 'jobs', 'projects', 'jobTypes', 'priorities', 'processMethods', 'jobId'));

    }


    public function detailAction(Request $request)
    {   
        $action = $request->input('action');
        
        $jobIds = $request->input('job_ids');

        switch ($action) {
            
            case 'detail':
                $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);
                if (count($jobIds) != 1) {
                    return redirect()->back()->withErrors(['jobs' => 'Chọn duy nhất một công việc']);
                }
                return view('jobs.job-detail', [
                    'jobs' => $jobs,
                    'jobId' => $jobIds[0]
                ]);                

            case 'finish':
                // TODO: finish function
                break;

            case 'search': 
                return redirect()->route('jobs.index');

            
            case 'assign':
                return redirect()->route('assignee-list.index', [
                    'jobIds' => $jobIds,
                ]);
            
            case 'timesheet': 
                if (!$jobIds) {
                    return redirect()->route('timesheet.create');
                }
                $jobId = $jobIds[0];
                return redirect()->route('timesheet.create', ['job_id' => $jobId]);

            case 'amount_confirm': 
                $jobId = $jobIds[0];
                return redirect()->route('amount-confirms.create', ['job_id' => $jobId]);
                break;

            case 'exchange': 
                // TODO: exchange view function
                break;
        }
    }


    public function action(Request $request)
    {

        $action = $request->input('action');
        
        switch ($action) {
            case 'save':
                return $this->save($request->all());

            case 'save_copy': 
                return $this->save($request->all(), true);

            case 'delete': 
                $id = $request->input('job_id');
                return $this->destroy($id);
                
            case 'search': 
                return redirect()->route('jobs.index');

        }

    }
    
    private function destroy ($id) 
    {

        if (!$id) {
            return redirect()->route('jobs.create')->withInput()->with('error', 'Chưa chọn công việc để xóa');
        }
        
        $job = Job::find($id);
        try {
            
            if ($job) {
                
                $job->delete();
                return redirect()->route('jobs.create')->with('success', 'Xóa công việc thành công');
            
            }
            else {
                
                return redirect()->route('jobs.create')->withInput()->with('error', 'Công việc không tồn tại');

            }

        }
        catch (Exception $e) {
            return redirect()->route('jobs.create')->withInput()->with('error', 'Đã có lỗi xảy ra');
        }
        
    } 

    private function save($data, $flashInputs=false) {
        $jobId = $data['job_id'];

        if ($jobId) {
            $validator = Validator::make($data, [ 
                'assigner_id' => 'required', 
                'name' => ['required', 'string'], 
                'deadline' => ['required', 'date'],
            ]);
        }
        else {
            $validator = Validator::make($data, [
                'code' => 'unique:jobs', 
                'assigner_id' => 'required', 
                'name' => ['required', 'string'], 
                'deadline' => ['required', 'date'],
            ]);
        }

        if ($validator->fails()) {
            return redirect()->route('jobs.create')->withInput()->withErrors($validator->errors());
        }

        $tableCols = DB::getSchemaBuilder()->getColumnListing('jobs');
        $jobData = array_filter(
            $data, 
            fn($key) => in_array($key, $tableCols),
            ARRAY_FILTER_USE_KEY
        );
        
        try {
            if ($jobId) {

                $job = Job::findOrFail($jobId);

                if ($job->isActive()) {

                    $jobUpdates = [];
                    $updateNote = isset($data['note']) ? $data['note'] : '';

                    foreach ($jobData as $key => $value) {
                        if ($value != $job[$key]) {
                            switch ($key) {
                                case "assigner_id":  
                                    $assigner = Staff::find($job['assigner_id']);
                                    $newAssigner = Staff::find($value);
                                    
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Người giao việc',
                                        "old_value" => $assigner->name,
                                        "new_value" => $newAssigner->name,
                                        "note" => $updateNote
                                    ]));    
                                         
                                    break;

                                case "project_id": 
                                    $project = Project::find($job['project_id']);
                                    $newProject = Project::find($value);

                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Dự án',
                                        "old_value" => $project ? $project->name : '',
                                        "new_value" => $newProject ? $newProject->name : '',
                                        "note" => $updateNote
                                    ]));
                                    break;

                                case "parent_id": 
                                    
                                    $parentJob = Job::find($job['parent_id']);
                                    $newParentJob = Job::find($value);
                                    
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Việc cha',
                                        "old_value" => $parentJob ? $parentJob->name : '',
                                        "new_value" => $newParentJob ? $newParentJob->name : '',
                                        "note" => $updateNote
                                    ]));
                                    break;

                                case "job_type_id": 
                                    
                                    $jobType = JobType::find($job['job_type_id']);
                                    $newJobType = JobType::find($value);
                                    
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Loại công việc',
                                        "old_value" => $jobType ? $jobType->name : '',
                                        "new_value" => $newJobType ? $newJobType->name : '',
                                        "note" => $updateNote
                                    ]));
                                    break;

                                case "process_method_id":
                                    
                                    $processMethod = ProcessMethod::find($job['process_method_id']);
                                    $newProcessMethod = ProcessMethod::find($value);
                                    
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Hình thức xử lý',
                                        "old_value" => $processMethod ? $processMethod->name : '',
                                        "new_value" => $newProcessMethod ? $newProcessMethod->name: '',
                                        "note" => $updateNote
                                    ]));
                                    break;

                                case "priority_id": 
                                    
                                    $priority = Priority::find($job['priority_id']);
                                    $newPriority = Priority::find($value);
                                    
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId,
                                        "field" => 'Loại công việc',
                                        "old_value" => $priority ? $priority->name : '',
                                        "new_value" => $newPriority ? $newPriority->name : '',
                                        "note" => $updateNote
                                    ]));
                                    break;

                                default: 
                                    array_push($jobUpdates, new UpdateJobHistory([
                                        "job_id" => $jobId, 
                                        "field" => $key, 
                                        "old_value" => $job[$key] ? $job[$key] : '',
                                        "new_value" => $value ? $value : '', 
                                        "note" => $updateNote
                                    ]));

                                    
                            }
                        }
                        
    
                    }

                    if ($jobUpdates) {
                        $job->updateHistories()->saveMany($jobUpdates);
                    }
                }

                $job->update($jobData);
                
            }
            else {
                $job = Job::create($jobData);
            }
        
            if (isset($data['job_files'])) {
                
                $files = $data['job_files'];

                foreach ($files as $file) {
                    
                    $originalFileName = ($file->getClientOriginalName());
                    $file->storeAs(File::UPLOAD_DIR, $originalFileName, 'public');


                    $newFile = File::create([
                        'staff_id' => $job->assigner_id, 
                        'name' => $originalFileName,
                        'dir' => File::UPLOAD_DIR
                    ]);
                    $job->files()->attach($newFile->id);
                  

                }
            }

            if ((isset($data['phoi-hop']) || isset($data['nhan-xet'])) && !isset($data['chu-tri'])) {
                return redirect()->route('jobs.create')->withInput()->with('error', 'Vui lòng chọn người chủ trì');
            }
    
            $processMethods = [
                'chu-tri' => 'chủ trì',
                'phoi-hop' => 'phối hợp',
                'nhan-xet' => 'nhận xét'
            ];
    
    
                
            foreach ($processMethods as $key => $value) {
                if (isset($data[$key])) {
                    
                    $processMethod = ProcessMethod::where('name', $value)->first();
                    
                    $result = $this->assignJob($data[$key], $processMethod, $job->id);
    
                    if (!$result['success']) {
                        return redirect()->route('jobs.create')->withInput()->with('error', 'Đã có lỗi xảy ra');
                    }
                }
            }
    
            $message = $jobId ? 'Sửa công việc thành công' : 'Thêm công việc thành công';
    
            if ($jobId || $flashInputs) {
                return redirect()->route('jobs.create')->withInput()->with('success', $message);
            }

            return redirect()->route('jobs.create')->with('success', $message);
        }
        catch (Exception $e) {
            return redirect()->route('jobs.create')->withInput()->with('error', 'Đã có lỗi xảy ra');
        }
    }


    private function assignJob($assignees, $processMethod, $jobId) {
        try {
            foreach($assignees as $assignee) {
            
                $assignee = json_decode($assignee, true);
                
                JobAssign::create([
                    'job_id' => $jobId,
                    'staff_id' => $assignee['staff_id'],
                    'process_method_id' => $processMethod->id,
                    'direct_report' => $assignee['direct_report'] ?? null,
                    'deadline' => $assignee['deadline'] ?? null,
                    'sms' => $assignee['sms'] ?? null
                ]);
    
            }
            return ['success' => true];
        } 
        catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }


    private function getHandlingJobs($staffId, $condition=[]) 
    {
        $directJobs = Job::with([
            'jobAssigns' => function ($query) use ($staffId){
                $query->where([
                    'staff_id'=> $staffId, 
                    'parent_id' => null,
                ])
                ->whereNotIn('status', ['pending', 'rejected']);
            }, 
            'jobAssigns.processMethod',
            'project:id,code', 
            'assigner:id,name', 
        ])
        ->where($condition)
        ->whereNotIn('status', ['pending', 'finished', 'canceled'])
        ->whereHas('jobAssigns', function ($query) use ($staffId) {
            $query->where([
                'staff_id'=> $staffId, 
                'parent_id' => null,
            ])
            ->whereNotIn('status', ['pending', 'rejected']);
        })->get();


        $relatedJobs = Job::with([
            'jobAssigns' => function ($query) use ($staffId){
                $query->where('staff_id', $staffId)
                    ->whereNotNull('parent_id')
                    ->whereNotIn('status', ['pending', 'rejected']);
            }, 
            'jobAssigns.parent.assignee:id,name',
            'jobAssigns.processMethod',
            'project:id,code', 
            'assigner:id,name', 
        ])
        ->where($condition)
        ->whereNotIn('status', ['pending', 'finished', 'canceled'])
        ->whereHas('jobAssigns', function ($query) use ($staffId) {
            $query->where('staff_id', $staffId)
                ->whereNotNull('parent_id')
                ->whereNotIn('status', ['pending', 'rejected']);
        })->get();




        $reformatedDirectJobs = $this->reformatHandlingJobs($directJobs);
        $reformatedRelatedJobs = $this->reformatHandlingJobs($relatedJobs, true);
        


        return [$reformatedDirectJobs, $reformatedRelatedJobs];
        
    }

    private function getPendingJobs($staffId, $condition=[]) 
    {
        $newAssignedJobs = Job::with([
            'jobAssigns' => function ($query) use ($staffId) {
                $query->where([
                    'staff_id' => $staffId,
                    'status' => 'pending'
                ]);
            }
        ])
        ->where($condition)
        ->whereHas('jobAssigns', function ($query) use ($staffId) {
            $query->where([
                'staff_id' => $staffId,
                'status' => 'pending'
            ]);
        })->get();




        $unassignedJobs = Job::where('status', 'pending')
        ->where($condition)
        ->doesntHave('jobAssigns')
        ->get();
        
        
        
        $reformatedNewAssignedJobs = $this->reformatPendingJobs($newAssignedJobs);
        
        $reformatedUnassignedJobs = $this->reformatPendingJobs($unassignedJobs);
        

        

        
        return [$reformatedNewAssignedJobs, $reformatedUnassignedJobs];
    }

    private function getAssignerJobs($staffId, $condition=null) 
    {
        $createdJobs = Job::where('assigner_id', $staffId)->with([
            'project:id,code',
            'assigner:id,name'
        ])->get();
        

        $forwardJobs = Job::with([
            'project:id,code',
            'assigner:id,name'
        ])
        ->whereHas('jobAssigns', function($query) use ($staffId){
            $query->where('staff_id', $staffId);
        })
        ->whereHas('jobAssigns.children')
        ->get();



        $reformatedCreatedJobs = $this->reformatAssignerJobs($createdJobs);
        
        $reformatedForwardJobs = $this->reformatAssignerJobs($forwardJobs);

        return [$reformatedCreatedJobs, $reformatedForwardJobs];
    }

    private function getAllJobsByStaffId($staffId, $condition=null)
    {

        $allJobs = Job::with([
            'jobAssigns',
            'assignees',
        ])
        ->where($condition)
        ->whereNotIn('status', ['rejected', 'cancelled'])
        ->where(function ($subQuery) use ($staffId){  
            
            $subQuery->where('assigner_id', $staffId)->orWhereHas('jobAssigns', function ($query) use ($staffId){
                $query->where('staff_id', $staffId);
            });

        })
        ->get();
        
        $reformatedAllJobs = $this->reformatAllJobs($allJobs);
        return $reformatedAllJobs;



    }


    private function reformatHandlingJobs($jobs, $related = false) 
    {

        foreach ($jobs as $item) {
            $item->project_code = $item->project ? $item->project->code : null;
            $item->assigner = $item->assigner->name;
            $item->process_method  = $item->jobAssigns[0]->processMethod->name;
            $item->timesheet_amount = null;
            $item->finished_percent = null;
            $item->remaining = null;
            $item->job_assign_id = $item->jobAssigns[0]->id;
            
            if ($related)
                $item->forward = $item->jobAssigns[0]->parent->assignee->name;


        }
        return $jobs;
    }

    private function reformatPendingJobs($jobs)
    {
        foreach ($jobs as $item) {
            
            $item->project_code = $item->project ? $item->project->code : null;
            $item->assigner = $item->assigner->name; 
            if ($item->jobAssigns->count()) {
                $item->job_assign_id = $item->jobAssigns[0]->id;
            }
        }

        return $jobs;
    }

    private function reformatAssignerJobs($jobs)
    {
        foreach ($jobs as $item) {
            $item->project_code = $item->project ? $item->project->code : null;
            $item->assigner = $item->assigner->name;
            $item->others = null;
            $item->remaining = null;
            $item->evaluation = null;

        }

        return $jobs;
    }

    public function reformatAllJobs($jobs)
    {
        $mainProcessMethod = ProcessMethod::where('name', 'chủ trì')->first();

        foreach ($jobs as $job) {
            
            $mainAssignee = null;
            $mainJobAssign = null;
            $others = [];

            $assignees = $job->assignees;
            $jobAssigns  = $job->jobAssigns;

            foreach ($jobAssigns as $jobAssign) {
                if ($jobAssign->process_method_id == $mainProcessMethod->id) {
                    $mainJobAssign = $jobAssign;
                    break;
                }
            }
            
            if ($mainJobAssign) {

                foreach ($assignees as $assignee) {
                    if ($assignee->id == $mainJobAssign->staff_id) {
                        $mainAssignee = $assignee;
                        break;
                    }
                }
              
            }


            foreach ($assignees as $assignee) {
                if (!$mainAssignee || $assignee->id != $mainAssignee->id) {
                    
                    $others[] = $assignee->name;
                }
            }


    
            
            
            $job->project_code = $job->project ? $job->project->code : null;
            $job->assigner = $job->assigner->name;
            $job->main_assignee = $mainAssignee ? $mainAssignee->name :null;
            $job->others = implode(',', $others);
            $job->remaining = null;
            $job->evaluation = null;


        }


        return $jobs;
    }

    

    


}
