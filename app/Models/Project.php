<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function scopeBelongsToStaff($query, $staffId)
    {
        return $query->whereHas('jobs', function ($subQuery) use ($staffId) {
            $subQuery->where('assigner_id', $staffId)
                ->orWhereHas('assignees', function ($q) use ($staffId) {
                    $q->where('staff.id', $staffId);
                });
        })
            ->orWhereHas('jobs.jobAssigns', function ($subQuery) use ($staffId) {
                $subQuery->where([
                        'staff_id' => $staffId,
                        'status' => JobAssign::STATUS_ACTIVE
                ])
                    ->whereHas('parent.job.project', function ($q){
                        $q->where('id', $this->id);
                    });
            });

    }


}
