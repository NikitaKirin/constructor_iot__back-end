<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Discipline\DisciplineResource;
use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function show( Request $request, Discipline $discipline ) {
        if ( !$discipline->exists() ) {
            return response()->json(
                ['data' => 'Not found'], 404
            );
        }
        return new DisciplineResource($discipline->load(['courses', 'professionalTrajectories']));
    }
}
