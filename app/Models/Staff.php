<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function account()
    {
        return $this->hasOne(Account::class);
    }
    
    public function jobs()
    {
        return $this->belongsToMany(Job::class)->using(JobAssign::class)->withPivot('role', 'direct_report', 'sms');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function communicationHistories()
    {
        return $this->hasMany(CommunicationHistory::class);
    }
}
