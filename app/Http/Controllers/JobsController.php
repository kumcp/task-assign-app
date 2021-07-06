<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\JobType;
use App\Models\Priority;
use App\Models\ProcessMethod;
use App\Models\Project;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        return view('jobs.index');
    }

    public function show($id)
    {
        $job = Job::with(['parent', 'type', 'project', 'priority', 'assigner'])->where('id', $id)->get()[0];
        return response($job);
    }

    public function create()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->get();
        $staff = Staff::all();
        $projects = Project::all();
        $jobTypes = JobType::all();
        $priorities = Priority::all();
        $processMethods = ProcessMethod::all();
        return view('jobs.create', compact('staff', 'jobs', 'projects', 'jobTypes', 'priorities', 'processMethods'));

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
                    return redirect()->route('jobs.create')->withErrors($result['message']);
                }
            case 'save_copy': 
                $result = $this->save($request->all());
                if ($result['status']) {
                    return redirect()->route('jobs.create')->withInput();
                }
                else {
                    return redirect()->refresh()->withErrors($result['message']);
                }
            case 'delete': 
                $id = $request->input('job_id');
                $result = $this->destroy($id);
                if ($result) {
                    return redirect()->route('jobs.create')->with('message', 'Xóa công việc thành công');
                }
            case 'search': 
                return redirect()->route('jobs.search');
        }


    }
    
    private function destroy ($id) 
    {
        $job = Job::findOrFail($id);
        return $job->delete();
        
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
    
    


}
