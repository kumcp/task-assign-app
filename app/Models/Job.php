<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_DEACTIVE = 'deactive';
    const PERIOD_UNIT_DAY = 'day';
    const PERIOD_UNIT_HOUR = 'hour';
    const PERIOD_UNIT_TERM = 'term';

    // Default attribute when create Model

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
        'period_unit' => self::PERIOD_UNIT_DAY,
    ];

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
        return $this->belongsToMany(File::class);
    }

    public function assigner()
    {
        return $this->belongsTo(Staff::class, 'assigner_id');
    }

    public function assignee()
    {
        return $this->belongsToMany(Staff::class, 'job_assigns')->using(JobAssign::class)->withPivot('role', 'direct_report', 'sms');
    }

    public function updateHistories()
    {
        return $this->hasMany(UpdateJobHistory::class);
    }
    public function jobAssign()
    {
        return $this->belongsTo(JobAssign::class);
    }
}
