<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobAssign extends Pivot
{
    protected $table = 'job_assigns';

    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';

    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    protected $guarded = [];

    
    public function parent()
    {
        return $this->belongsTo(JobAssign::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(JobAssign::class, 'parent_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function assignee()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function workPlans()
    {
        return $this->hasMany(WorkPlan::class, 'job_assign_id');
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
