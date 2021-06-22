<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobAssign extends Pivot
{
    public function workplans()
    {
        return $this->hasMany(WorkPlan::class);
    }

    public function timesheets()
    {
        return $this->hasMany(TimeSheet::class);
    }
}
