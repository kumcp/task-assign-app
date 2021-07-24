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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    const DEFAULT_PAGINATE = 15;

    public function index(Request $request)
    {


        if ($request->has(['type', 'staff-id'])) {
           
            $type = $request->input('type');
            $staffId = $request->input('staff-id');
            
            $jobTypes = JobType::orderBy('name')->get();
            $assigners = Staff::orderBy('name')->get();
            $projects = Project::orderBy('name')->get();

            $condition = [];
            if ($request->method() === 'POST') {
                
                foreach ($request->all() as $key => $value) {
                    if (!in_array($key, ['type', 'staff-id', 'from_date', 'to_date']) && $value)
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
                    return view('jobs.pending-jobs', compact('newAssignedJobs', 'unassignedJobs', 'jobTypes', 'assigners', 'projects'));
                
                case 'handling': 
                    [$directJobs, $relatedJobs] = $this->getHandlingJobs($staffId, $condition);
                    return view('jobs.handling-jobs', compact('directJobs', 'relatedJobs', 'jobTypes', 'assigners', 'projects'));

                case 'assigner': 
                    $createdJobs = $this->getAssignerJobs($staffId, $condition);


                default: 
                    break;

                
            }

        }
        else {
            $jobs = Job::all();
            return view('jobs.index', compact($jobs));
        }

    }

    public function show($id)
    {
        $job = Job::with(['parent', 'type', 'project', 'priority', 'assigner'])->where('id', $id)->first();
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
        
        
        switch ($action) {
            
            case 'detail':
                
                $jobIds = $request->input('job_ids');
                $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);

                if (count($jobIds) == 1) {

                    return view('jobs.job-detail', [
                        'jobs' => $jobs,
                        'jobId' => $jobIds[0]
                    ]);
                    
                }

                return redirect()->back()->withErrors(['jobs' => 'Chọn duy nhất một công việc']);
                 
                

            case 'finish':
                // TODO: finish function
                break;

            case 'search': 
                // TODO: redirect to search view
                break;
            
            case 'assign':
                // TODO: assign view function
                break;
            
            case 'timesheet': 
                // TODO: timesheet view function
                break;

            case 'amount_confirm': 
                // TODO: amount confirm view function
                break;

            case 'exchange': 
                // TODO: exchange view function
                break;
        }
    }


    

    public function updateStatus(Request $request) {
        $action = $request->input('action');
        $jobId = $request->input('job_id');
        $staffId = $request->input('staff_id');
        
        $job = Job::findOrFail($jobId);
        $jobs = Job::orderBy('created_at', 'DESC')->paginate($this::DEFAULT_PAGINATE);

        $jobAssign = JobAssign::where([
            'job_id' => $jobId, 
            'staff_id' => $staffId
        ])->first();

        switch ($action) {
            case 'accept':
                $workplanRequired = Configuration::where('field', 'workplan')->first('value')->value;
                
                if ($workplanRequired == 'true') {

                    if ($jobAssign) {
                        $request->session()->put('job_assign_id', $jobAssign->id);
                    }

                    else {
                        $request->session()->put([
                            'job_id' =>  $jobId,
                            'staff_id' => $staffId
                        ]);
                    }
                    return redirect()->route('workplans.create');
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


    public function action(Request $request)
    {

        $action = $request->input('action');
        switch ($action) {
            case 'save': 
                $result = $this->save($request->all());
                if ($result['status']) {
                    return redirect()->route('jobs.create')->with('success', $result['message']);
                }
                else {
                    return redirect()->route('jobs.create')->withInput()->withErrors($result['message']);
                }

            case 'save_copy': 
                $result = $this->save($request->all());
                if ($result['status']) {
                    return redirect()->route('jobs.create')->withInput()->with('success', $result['message']);
                }
                else {
                    return redirect()->route('jobs.create')->withErrors($result['message']);
                }

            case 'delete': 
                $id = $request->input('job_id');
                if (!$id) { 
                    return redirect()->route('jobs.create')->withErrors([
                        'job_id' => 'Chưa chọn công việc để xóa'
                    ]);
                }


                $result = $this->destroy($id);

                if ($result['status']) {
                    return redirect()->route('jobs.create')->with('success', $result['message']);
                }
                else {
                    return redirect()->route('jobs.create')->withInput()->withErrors($result['message']);
                }
                
            case 'search': 
                return redirect()->route('jobs.search');

            
        }


    }
    
    private function destroy ($id) 
    {
        $job = Job::find($id);
        try {
            if ($job) {
                $job->delete();
                return ['status' => true, 'message' => 'Xóa công việc thành công'];
            }
            else {
                return ['status' => false, 'message' => 'Chưa chọn công việc'];
            }

        }
        catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
        
    } 

    private function save($data) {
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
            return ['status' => false, 'message' => $validator->errors()];
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

                if ($job->status == 'active') {

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
                    $filePath = $file->store(File::UPLOAD_DIR, 'public');
                    $fileName = explode('/', $filePath)[2];
                    $newFile = File::create([
                        'staff_id' => $job->assigner_id, 
                        'name' => $fileName,
                        'dir' => File::UPLOAD_DIR
                    ]);
                    $job->files()->attach($newFile->id);
                }
            }

            $message = $jobId ? 'Sửa công việc thành công' : 'Thêm công việc thành công';
            return ['status' => true, 'message' => $message];
        }
        catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
        
        //TODO: insert into job_assigns table
    }





    private function getHandlingJobs($staffId, $condition=[]) 
    {
        try {



            $directJobs = Job::with([
                'jobAssigns' => function ($query) use ($staffId){
                    $query->where(['staff_id'=> $staffId, 'parent_id' => null]);
                }, 
                'jobAssigns.processMethod',
                'jobAssigns.timeSheets',
                'project:id,code', 
                'assigner:id,name', 
            ])
            ->where($condition)
            ->whereHas('jobAssigns', function ($query) use ($staffId) {
                $query->where(['staff_id'=> $staffId, 'parent_id' => null]);
            })->get();


            $relatedJobs = Job::with([
                'jobAssigns' => function ($query) use ($staffId){
                    $query->where('staff_id', $staffId)->whereNotNull('parent_id');
                }, 
                'jobAssigns.parent.assignee:id,name',
                'jobAssigns.processMethod',
                'jobAssigns.timeSheets',
                'project:id,code', 
                'assigner:id,name', 
            ])
            ->where($condition)
            ->whereHas('jobAssigns', function ($query) use ($staffId) {
                $query->where('staff_id', $staffId)->whereNotNull('parent_id');
            })->get();




            $reformatedDirectJobs = $this->reformatHandlingJobs($directJobs);
            $reformatedRelatedJobs = $this->reformatHandlingJobs($relatedJobs, true);
            


            return [$reformatedDirectJobs, $reformatedRelatedJobs];


        } 
        catch (Exception $e) {
            dd($e);
        }
        
    }

    private function getPendingJobs($staffId, $condition=[]) 
    {
        $newAssignedJobs = Job::with([
            'jobAssigns' => function ($query) use ($staffId) {
                $query->where('staff_id', $staffId);
            }
        ])
        ->where('status', 'pending')
        ->where($condition)
        ->whereHas('jobAssigns', function ($query) use ($staffId) {
            $query->where('staff_id', $staffId);
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
        $createdJobs = Job::where('assigner_id', $staffId)->get();
        
        // TODO: get forward jobs 
        return $createdJobs;
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
    

    


}
