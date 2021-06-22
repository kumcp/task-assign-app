<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    public function jobAssign()
    {
        return $this->belongsTo(JobAssign::class);
    }
}
