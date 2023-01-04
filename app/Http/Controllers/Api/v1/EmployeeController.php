<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeResourceCollection;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($positionId = $request->input('positionId')) {
            return new EmployeeResourceCollection(
                Employee::where('position_id', $positionId)
                    ->with(['position'])
                    ->orderBy('full_name')
                    ->get()
            );
        }
        return new EmployeeResourceCollection(Employee::orderBy('full_name')->with(['position'])->get());
    }
}