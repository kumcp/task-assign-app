<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;

    public function jobAssign()
    {
        return $this->belongsTo(JobAssign::class);
    }

    public function timeDate(){
        $fromTime = strtotime($this->form_time);
        $toTime = strtotime($this->to_time);

        $fromDate = strtotime($this->from_date);
        $toDate = strtotime($this->to_date);

        $absHour = abs($toTime - $fromTime);
        $hour = floor($absHour/(60*60));

        $absDate = floor($toDate - $fromDate);
        $date = floor($absDate/(60*60*24));

        $dateDiff = $hour*($date+1);

        $jod_period = $this->jobAssign->job->period*8;

        return number_format(($dateDiff/$jod_period)*100, 2, '.', '');
    }
}
