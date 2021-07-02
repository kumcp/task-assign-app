<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessMethod extends Model
{
    public function jobAssigns()
    {
        return $this->hasMany(JobAssign::class);
    }
}
