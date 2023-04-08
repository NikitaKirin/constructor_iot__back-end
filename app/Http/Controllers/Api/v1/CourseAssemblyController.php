<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseAssembly\CourseAssemblyResource;
use App\Models\CourseAssembly;
use Illuminate\Http\Request;

class CourseAssemblyController extends Controller
{
    public function show(Request $request, CourseAssembly $courseAssembly ) {
        if ( !$courseAssembly->exists() ) {
            return response()->json(
                ['data' => 'Not found'], 404
            );
        }
        return new CourseAssemblyResource($courseAssembly->load(['courses', 'professionalTrajectories', 'courses.partner']));
    }
}
