<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departmentList = Department::with('staffs')->get();

        $reformat = $this->reformat($departmentList, 'name', 'staffs');

        return response()->json($reformat, Response::HTTP_OK);
    }

    private function reformat($collection, $textAttr, $childAttr, $stop = false)
    {
        $reformat = [];
        if ($collection == null) {
            return null;
        }
        foreach ($collection as $item) {
            $reformatObj = [
                'text' => $item->$textAttr,
            ];

            if (!$stop && $item->$childAttr !== null && count($item->$childAttr) > 0) {
                $reformatObj['children'] = $this->reformat($item->$childAttr, $textAttr, $childAttr, $stop);
            }

            $reformat[] = $reformatObj;
        }

        return $reformat;
    }
}
