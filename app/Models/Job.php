<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_DEACTIVE = 'deactive';
    const PERIOD_UNIT_DAY = 'day';
    const PERIOD_UNIT_WEEK = 'week';
    const PERIOD_UNIT_MONTH = 'month';
    const PERIOD_UNIT_QUARTER = 'quarter';
    const PERIOD_UNIT_YEAR = 'year';

    // Default attribute when create Model

    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'period_unit' => self::PERIOD_UNIT_DAY,
    ];

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Job::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(JobType::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'job_files');
    }

    public function assigner()
    {
        return $this->belongsTo(Staff::class, 'assigner_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(Staff::class, 'job_assigns')->using(JobAssign::class)->withPivot(
            'process_method_id', 
            'parent_id', 
            'direct_report', 
            'sms', 
            'status', 
            'deny_reason',
            'deadline'
        );
    }

    public function jobAssigns()
    {
        return $this->hasMany(JobAssign::class, 'job_id');
    }


    public function updateHistories()
    {
        return $this->hasMany(UpdateJobHistory::class, 'job_id');
    }


    public function isActive()
    {
        return $this->status == 'active';
    }

    public function getRemaining()
    {
        $deadline = Carbon::parse($this->deadline);
        $now = Carbon::now();
        return $now->greaterThanOrEqualTo($deadline) ? 0 : $now->diffInDays($deadline);
    }

    public function getMainAssignee()
    {
        $mainJobAssign = JobAssign::with(
            'assignee'
        )
        ->where('job_id', $this->id)
        ->mainJobAssign()
        ->first();
        
        return $mainJobAssign ? $mainJobAssign->assignee : null;
    }

    public function getOtherAssignees()
    {
        $mainAssignee = $this->getMainAssignee();
        $assignees = $this->load('assignees')->assignees;
        if ($mainAssignee) {
            return $assignees->filter(function($assignee) use ($mainAssignee) {
                return $assignee->id != $mainAssignee->id;
            });
        }
        return $assignees;
    }



}
