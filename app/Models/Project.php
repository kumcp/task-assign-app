<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
