<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSheet;

class TimeSheetController extends Controller
{
    public function create(){
        $timeSheets = TimeSheet::paginate(10);
        return view('site.time-sheet.timesheet', compact('timeSheets'));
    }
    public function edit($id){
        $timeSheet = TimeSheet::findOrFail($id);
        $timeSheets = TimeSheet::paginate(10);
        return view('site.time-sheet.timesheet-edit', compact('timeSheets', 'timeSheet'));
    }
}
