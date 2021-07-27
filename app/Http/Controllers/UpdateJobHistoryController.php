<?php

namespace App\Http\Controllers;

use App\Models\UpdateJobHistory;
use Illuminate\Http\Request;

class UpdateJobHistoryController extends Controller
{
    public function index(Request $request)  
    {

        if ($request->has('job-id')) {
            $jobId = $request->input('job-id');
            $histories = UpdateJobHistory::where('job_id', $jobId)->get();
            return response()->json($histories);
        }
        else {
            return response(UpdateJobHistory::all());
        }
    }
    
}
