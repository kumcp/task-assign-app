<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheetRequest;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\Staff;
use App\Models\TimeSheet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TimeSheetController extends Controller
{
    public const DEFAULT_PAGINATE = 15;
    

    public function create(Request $request)
    {
        $staffId = Auth::user()->staff_id;

        $readonly = false;
        $assignees = [];
        $directJobs = [];
        $defaultStaffId = $request->input('staff_id');
        $defaultJobId = $request->input('job_id');
        $job = Job::with('assignees')->where('id', $defaultJobId)->first();

        if ($job && $this->isReadOnly($job, $staffId)) {
            $readonly = true;
            $assignees = $job->assignees;
            
            if (!$defaultStaffId && $assignees->count() > 0) {
                $firstAssignee = $assignees[0];
                $defaultStaffId = $firstAssignee->id;
            }

            $timeSheets = $this->queryTimeSheets($job->id, $defaultStaffId);
        }
        else {
            $directJobs = $this->getDirectJobs($staffId);
            $timeSheets = $this->getTimeSheets($directJobs);
        }

        return view('site.time-sheet.timesheet', compact('assignees', 'defaultJobId', 'defaultStaffId', 'job', 'timeSheets', 'directJobs', 'readonly'));
    }

    public function store(TimeSheetRequest $request){

        $jobId = $request->input('job_id');
        $assigneeId = Auth::user()->staff_id;
        $jobAssign = JobAssign::where([
            'job_id' => $jobId,
            'staff_id' => $assigneeId
        ])
        ->with('job')
        ->first();
        $job = $jobAssign->job;

        $data = $request->only(['from_date', 'to_date', 'from_time', 'to_time','content']);

        $fromDate = Carbon::parse($data['from_date']);
        $toDate = Carbon::parse($data['to_date']);
        $deadline = Carbon::parse($job->deadline);

        if ($this->checkPastDueDeadline($fromDate, $toDate, $deadline)) {
            return redirect()->back()->withInput()->with('error', 'Ngày nhập không được vượt quá deadline');
        }

        $data = array_merge(['job_assign_id' => $jobAssign->id], $data);
        try {
            TimeSheet::create($data);
            return redirect()->route('timesheet.create', ['job_id' => $jobId])->with('success','Đã thêm timesheet thành công');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã có lỗi xảy ra');
        }   


    }

    public function edit($id){
        $timeSheet = TimeSheet::with([
            'jobAssign',
            'jobAssign.job',
            'jobAssign.job.assignees'
        ])
        ->where('id', $id)
        ->first();

        if (!$timeSheet) {
            return redirect()->back()->with('error', 'Không tìm thấy timesheet');
        }

        $readonly = false;
        
        $job = $timeSheet->jobAssign->job;
        $timeSheet->percentage_completed = $timeSheet->getPercentageCompleted();

        $staffId = Auth::user()->staff_id;
        
        if ($this->isReadOnly($job, $staffId)) {
            $readonly = true;
            $assigneeId = $timeSheet->jobAssign->staff_id;
            $timeSheets = $this->queryTimeSheets($job->id, $assigneeId);
            $assignees = $job->assignees;
            return view('site.time-sheet.timesheet-edit', compact('assignees', 'job', 'timeSheets', 'timeSheet', 'readonly'));
        }

        $timeSheets = TimeSheet::whereHas('jobAssign', function($query) use ($staffId){
            $query->where(['staff_id' => $staffId]);
        })->get();

        $directJobs = $this->getDirectJobs($staffId);
        return view('site.time-sheet.timesheet-edit', compact('job', 'directJobs', 'timeSheets', 'timeSheet', 'readonly'));

    }

    public function update(TimeSheetRequest $request, $id){
        $action = $request->input('action');
        if ($action == 'reset') {
            return redirect()->route('timesheet.create');
        }

        $timeSheet = TimeSheet::with([
            'jobAssign',
            'jobAssign.job'
        ])
        ->where('id', $id)
        ->first();

        $data = $request->only(['from_date', 'to_date', 'from_time', 'to_time','content']);

        $job = $timeSheet->jobAssign->job;
        $fromDate = Carbon::parse($data['from_date']);
        $toDate = Carbon::parse($data['to_date']);
        $deadline = Carbon::parse($job->deadline);
        
        if ($this->checkPastDueDeadline($fromDate, $toDate, $deadline)) {
            return redirect()->back()->withInput()->with('error', 'Ngày nhập không được vượt quá deadline');
        }

        try {
            $timeSheet->update($data);
            return redirect()->route('timesheet.edit', ['id' => $id])->with('success','Đã sửa timesheet thành công');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã có lỗi xảy ra');
        }   
    }

    public function destroy($id) {
        $timeSheet = TimeSheet::find($id);
        if (!$timeSheet) {
            return redirect()->back()->withInput()->with('error', 'Không tìm thấy timesheet');
        }

        try {
            $timeSheet->delete();
            return redirect()->route('timesheet.create')->with('success','Đã xóa timesheet thành công');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã có lỗi xảy ra');
        } 
    }

    private function isReadOnly($job, $staffId)
    {
        $jobAssign = JobAssign::where([
            'job_id' => $job->id,
            'staff_id' => $staffId
        ])
        ->first();
        return $job->assigner_id == $staffId || ($jobAssign && $jobAssign->hasForwardChild());

    }

    private function getDirectJobs($staffId)
    {
        $directJobs = Job::with([
            'jobAssigns' => function ($query) use ($staffId){
                $query->directAssign($staffId);
            }, 
        ])
        ->whereHas('jobAssigns', function ($query) use ($staffId) {
            $query->directAssign($staffId);
        })->get();
        return $directJobs;
    }

    private function queryTimeSheets($jobId, $assigneeId)
    {
        if (!$assigneeId) {
            return TimeSheet::belongsToJob($jobId)->get();
        }
        $timeSheets = TimeSheet::belongsToJob($jobId)->whereHas('jobAssign', function ($query) use ($assigneeId) {
            $query->where('staff_id', $assigneeId);
        })
        ->get();
        return $timeSheets;
    }
    
    private function getTimeSheets($jobs)
    {
        $timeSheets = [];
        foreach ($jobs as $job) {
            foreach ($job->jobAssigns as $jobAssign) {
                foreach ($jobAssign->timeSheets as $timeSheet) {
                    $timeSheets[] = $timeSheet;
                }
            }   
        }
        return $timeSheets;
    }

    private function checkPastDueDeadline($fromDate, $toDate, $deadline)
    {
        return $fromDate->greaterThan($deadline) || $toDate->greaterThan($deadline);
    }

}
