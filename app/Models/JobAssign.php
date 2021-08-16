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
        return $this->belongsTo(Job::class, 'job_id');
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
        return $this->hasMany(TimeSheet::class, 'job_assign_id');
    }

    public function amountConfirms()
    {
        return $this->hasMany(AmountConfirm::class, 'job_assign_id');
    }

    public function isDirectReport()
    {
        return $this->direct_report;
    }

    public function isChildOf($jobAssignId) 
    {
        return $this->parent_id == $jobAssignId;
    }

    public function isForwardOrAdditional() 
    {
        return $this->parent_id != null;
    }

    public function isAdditional()
    {
        return $this->is_additional;
    }

    public function isForward()
    {
        return $this->isForwardOrAdditional() && !$this->isAdditional();
    }

}
