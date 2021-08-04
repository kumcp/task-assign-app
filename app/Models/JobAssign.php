<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobAssign extends Model
{
    protected $table = 'job_assigns';

    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const DENY_REASON = 'deny_reason';

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
        'deny_reason' => self::DENY_REASON,
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

    public function job(){
        return $this->belongsTo(Job::class);
    }

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
}
