<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPlan extends Model
{
    protected $fillable = ['job_assign_id', 'from_date', 'to_date', 'from_time', 'to_time', 'content'];

    public function jobAssigned()
    {
        return $this->belongsTo(JobAssign::class);
    }
}
