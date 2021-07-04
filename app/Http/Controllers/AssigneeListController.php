<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class AssigneeListController extends Controller
{
    public function index()
    {
        $jobs = Job::get();

        return view(
            'jobs.assignee-list',
            compact('jobs')
        );
    }
}
