<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'position'];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function jobsCreated()
    {
        return $this->hasMany(Job::class);
    }

    public function jobsAssigned()
    {
        return $this->belongsToMany(Job::class, 'job_assigns')->using(JobAssign::class)->withPivot('role', 'direct_report', 'sms');
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

    public function amountConfirms()
    {
        return $this->hasMany(AmountConfirm::class);
    }

    public function info()
    {
        return $this->hasOne(StaffInfo::class);
    }
}
