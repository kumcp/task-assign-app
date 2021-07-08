<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeSheetController extends Controller
{
    public function list(){
        return view('site.jobs.timesheet');
    }
}
