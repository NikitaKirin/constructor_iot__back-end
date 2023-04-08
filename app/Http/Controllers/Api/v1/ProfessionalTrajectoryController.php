<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionalTrajectory\IndexProfessionalTrajectoryRequest;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\ProfessionalTrajectory;
use Illuminate\Http\Request;

class ProfessionalTrajectoryController extends Controller
{
    public function index(Request $request) {
        $withProfessions = $request->boolean('loadProfessions');
        $professionalTrajectoryQuery = ProfessionalTrajectory::query()->with(['icons']);
        if ($withProfessions) {
            $professionalTrajectoryQuery = $professionalTrajectoryQuery->with(['professions']);
        }
        return new ProfessionalTrajectoryResourceCollection($professionalTrajectoryQuery->orderBy('title')->get());
    }

    public function show(ProfessionalTrajectory $professionalTrajectory, Request $request) {
        $professionalTrajectory->load(['icons']);
        if ($request->boolean('loadCourseAssembliesCount')) {
           $professionalTrajectory->loadCount('courseAssemblies');
        }
        if ($request->boolean('loadProfessions')){
            $professionalTrajectory->load(['professions']);
        }
        return new ProfessionalTrajectoryResource($professionalTrajectory);
    }
}
