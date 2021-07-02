<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobAssign extends Model
{
    protected $table = 'job_assigns'; 

    public function workPlans()
    {
        return $this->hasMany(WorkPlan::class);
    }

    public function processMethod()
    {
        return $this->belongsTo(ProcessMethod::class);
    }

    public function timeSheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function amountConfirms()
    {
        return $this->hasMany(AmountConfirm::class);
    }
}
