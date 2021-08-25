<?php 

namespace App\Http\Common;

use App\Models\TimeSheet;

class JobChecker 
{
    public static function isPastDueDeadline($fromDate, $toDate, $deadline)
    {
        return $fromDate->greaterThan($deadline) || $toDate->greaterThan($deadline);
    }

    public static function isOverAssignAmount($requestInput, $jobId, $assignAmount, $timeSheetId = null)
    {
        $requestTimeSheet = new TimeSheet($requestInput);
        $requestAmount = $requestTimeSheet->workAmountInHour();
        
        $timeSheetsTillNow = TimeSheet::whereHas('jobAssign.job', function ($query) use ($jobId, $timeSheetId) {
            $query->where('job_id', $jobId);
        })
        ->beforeTime($requestInput['to_date'], $requestInput['to_time'])
        ->get();
        
        if ($timeSheetId) {
            $timeSheetsTillNow = $timeSheetsTillNow->filter(function ($timeSheet) use ($timeSheetId) {
                return $timeSheet->id != $timeSheetId;
            });
        }

        $totalTimeSheetAmount = $requestAmount;
        foreach($timeSheetsTillNow as $timeSheet) {
            $totalTimeSheetAmount += $timeSheet->workAmountInHour();
        }
        return $totalTimeSheetAmount > ($assignAmount * 8);
    }
}