<?php 

namespace App\Http\Common;


class JobChecker 
{
    public static function isPastDueDeadline($fromDate, $toDate, $deadline)
    {
        return $fromDate->greaterThan($deadline) || $toDate->greaterThan($deadline);
    }
}