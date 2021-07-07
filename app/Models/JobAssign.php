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
