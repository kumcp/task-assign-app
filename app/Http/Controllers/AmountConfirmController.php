<?php

namespace App\Http\Controllers;

use App\Models\AmountConfirm;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\TimeSheet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AmountConfirmController extends Controller
{

    public function create(Request $request)
    {

        $confirmAssigneeId = Auth::user()->staff_id;

        $jobId = $request->input('job_id');


        $job = Job::with([
            'assignees',
            'jobAssigns',
            'jobAssigns.assignee',
            'jobAssigns.processMethod',
            'jobAssigns.timeSheets',
            'jobAssigns.amountConfirms' => function($query) {
                $query->orderBy('month', 'DESC');
            },
        ])
        ->where('id', $jobId)
        ->first();

        $amountConfirms = [];

        if ($job->assignees->count() > 0) {
            
            $assignees = [];
            $jobAssigns = [];

            if ($job->assigner_id != $confirmAssigneeId) {
                $confirmJobAssign = $job->jobAssigns->where('staff_id', $confirmAssigneeId)->first();

                foreach ($job->jobAssigns as $jobAssign) {
                    
                    if ($jobAssign->parent_id == $confirmJobAssign->id && !$jobAssign->direct_report) {                        
                        $jobAssigns[] = $jobAssign;
                    }    
                }
            }
            else {
                foreach ($job->jobAssigns as $jobAssign) {
                    
                    if (!$jobAssign->parent_id || $jobAssign->direct_report) {
                        $jobAssigns[] = $jobAssign;
                    }

                }
            }

            foreach ($jobAssigns as $jobAssign) {

                $assignees[] = $jobAssign->assignee;

                foreach ($jobAssign->amountConfirms as $amountConfirm) {
                    $amountConfirm->assignee_name = $jobAssign->assignee->name;
                    $amountConfirms[] = $amountConfirm;
                }
            }



            $job->assignees = $assignees;


        }

        return view('jobs.amount-confirm', compact('job', 'amountConfirms'));

    }


    public function queryAmountConfirm(Request $request) {


        if (!($request->has('id') || $request->has(['staffId', 'month']))) {
            return response('', 400);
        }


        if ($request->has('id')) {
            $amountConfirmId = $request->input('id');

            $amountConfirm = AmountConfirm::with([
                'jobAssign',
                'jobAssign.job'
            ])
            ->where('id', $amountConfirmId)
            ->first();

            if (!$amountConfirm) {
                return response('', 404);
            }

            $jobAssign = $amountConfirm->jobAssign;
            
            if (!$jobAssign) {
                return response('', 400);
            }


            $oldAmountConfirm = AmountConfirm::where(
                'job_assign_id', $jobAssign->id
            )
            ->whereDate('month', '<', $amountConfirm->month)
            ->sum('confirm_amount');

            $time = Carbon::parse($amountConfirm->month);

            $timeSheets = TimeSheet::where('job_assign_id', $jobAssign->id)
            ->whereMonth('from_date', $time->month)
            ->whereYear('from_date', $time->year)
            ->get();


            

        }
        else {
            $staffId = $request->input('staffId');
            $time = $request->input('month');

            $monthYear = explode('-', $time);


            $jobId = $request->input('jobId');

            $jobAssign =  JobAssign::where([
                'job_id' => $jobId,
                'staff_id' => $staffId
            ])
            ->with('job')
            ->first();

            if (!$jobAssign) {
                return response('', 400);
            }

            $assignAmount = $jobAssign->job->assign_amount;

            $oldAmountConfirm = AmountConfirm::where(
                'job_assign_id', $jobAssign->id
            )
            ->whereDate('month', '<', Carbon::parse($time))
            ->sum('confirm_amount');
    


            $amountConfirm = AmountConfirm::where(
                'job_assign_id', $jobAssign->id
            )
            ->whereMonth('month', $monthYear[1])
            ->whereYear('month', $monthYear[0])
            ->with('jobAssign')
            ->first();

            $timeSheets = TimeSheet::where('job_assign_id', $jobAssign->id)
            ->whereMonth('from_date', $monthYear[1])
            ->whereYear('from_date', $monthYear[0])
            ->get();



        }



        $assignAmount = $jobAssign->job->assign_amount;

        $oldAmountConfirmPercent = $oldAmountConfirm * 100 / $assignAmount;


        $totalTimeSheetAmount = 0;
        
        foreach ($timeSheets as $timeSheet) {
            $totalTimeSheetAmount += $timeSheet->workAmountInManday();
        }


        $requestAmount = $amountConfirm ? $amountConfirm->request_amount : $totalTimeSheetAmount;
        
        $requestPercent = ($oldAmountConfirm + $requestAmount) * 100 / $assignAmount;


        if (!$amountConfirm) {
            return response()->json([
                'old_confirm_amount' => $oldAmountConfirm,
                'old_confirm_percentage' => $oldAmountConfirmPercent,
                'request_amount' => $requestAmount,
                'request_percentage' => $requestPercent
            ]);
        }

        $amountConfirm->old_confirm_amount = $oldAmountConfirm;
        $amountConfirm->old_confirm_percentage = $oldAmountConfirmPercent;
        $amountConfirm->request_amount = $requestAmount;
        $amountConfirm->request_percentage = $requestPercent;

        return response()->json($amountConfirm);


    }


    public function action(Request $request) {
        $action = $request->input('action');

        try {

            if ($action == 'save') {


                $rules = [
                    'confirm_amount' => ['required', 'lte:request_amount'],
                ];
        
                $messages = [
                    'confirm_amount.required' => 'Khối lượng xác nhận là bắt buộc',
                    'confirm_amount.lte' => 'Khối lượng xác nhận không được vượt quá khối lượng đề nghị'
                ];
        
                $validator = Validator::make($request->all(), $rules, $messages);
        
                if ($validator->fails()) {
                    return redirect()->back()->withInput()->withErrors($validator->errors());
                }
    
                
                $amountConfirmId = $request->input('amount_confirm_id');

                if ($amountConfirmId) {

                    
                    $amountConfirm = AmountConfirm::find($amountConfirmId);
                    
                    if (!$amountConfirm) {
                        return redirect()->back()->withInput()->with('error', 'Không tìm thấy xác nhận sản lượng');
                    }

                    $amountConfirm->update([
                        'confirm_amount' => $request->input('confirm_amount'),
                        'percentage_on' => $request->input('confirm_percentage'),
                        'quality' => $request->input('quality'),
                        'note' => $request->input('note')
                    ]);

                    return redirect()->back()->with('success', 'Xác nhận sản lượng thành công');
    
    
                }
        
                $jobId = $request->input('job_id');
                
                $staffId = $request->input('assignee');
        
                $confirmAssigneeId = Auth::user()->staff_id;

                $confirmAssigneeJobAssign = JobAssign::where([
                    'job_id' => $jobId,
                    'staff_id' => $staffId
                ])
                ->with('job')
                ->first();
        
                $jobAssign = JobAssign::where([
                    'job_id' => $jobId,
                    'staff_id' => $staffId
                ])
                ->first();

                $monthYear = explode('-', $request->input('month'));

                $amountConfirm = AmountConfirm::where(
                    'job_assign_id', $jobAssign->id
                )
                ->whereMonth('month', $monthYear[1])
                ->whereYear('month', $monthYear[0])
                ->first();

                if ($amountConfirm) {

                    $amountConfirm->update([
                        'confirm_amount' => $request->input('confirm_amount'),
                        'percentage_on' => $request->input('confirm_percentage'),
                        'quality' => $request->input('quality'),
                        'note' => $request->input('note')
                    ]);
                }
                else {
                    AmountConfirm::create([
                        'job_assign_id' => $jobAssign->id,
                        'staff_id' => $confirmAssigneeId,
                        'month' => Carbon::parse($request->input('month')),
                        'confirm_amount' => $request->input('confirm_amount'),
                        'request_amount' => $request->input('request_amount'),
                        'percentage_on' => $request->input('confirm_percentage'),
                        'quality' => $request->input('quality'),
                        'note' => $request->input('note')
                    ]);

                    if ($confirmAssigneeJobAssign && $jobAssign->parent_id == $confirmAssigneeJobAssign->id && !$jobAssign->is_additional) {
                        AmountConfirm::create([
                            'job_assign_id' => $confirmAssigneeJobAssign->id,
                            'staff_id' => $confirmAssigneeJobAssign->job->assigner_id,
                            'month' => Carbon::parse($request->input('month')),
                            'confirm_amount' => 0,
                            'request_amount' => $request->input('confirm_amount'),
                            'percentage_on' => $request->input('confirm_percentage'),
                        ]);
                    }
                }
                
                return redirect()->back()->with('success', 'Xác nhận sản lượng thành công');
    
    
            }
            else if ($action == 'reset') {

                return redirect()->route('amount-confirms.create', ['job_id' => $request->input('job_id')]);
            
            }
            else {
                $amountConfirmId = $request->input('amount_confirm_id');            
                $amountConfirm = AmountConfirm::find($amountConfirmId);

                if (!$amountConfirm) {
                    return redirect()->back()->withInput()->with(
                        'error', 'Không tìm thấy xác nhận sản lượng'
                    );
                }
    
                $amountConfirm->delete();
                return redirect()->back()->with('success', 'Xóa xác nhận sản lượng thành công');
        
            }


        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Đã có lỗi xảy ra');
        }

    }


    
}
