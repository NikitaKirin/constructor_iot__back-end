<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\EducationalProgram;
use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProfessionalTrajectoryController extends Controller
{
    public function index(Request $request, EducationalProgram $educationalProgram) {
        $withProfessions = $request->boolean('loadProfessions');
        $professionalTrajectoryQuery = ProfessionalTrajectory::query()->with(['icons'])
            ->whereHas('courseAssemblies.discipline.educationalPrograms',
                fn(Builder $builder) => $builder->where('id', $educationalProgram->id)
            );
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
        if ($request->boolean('loadProfessions')) {
            $professionalTrajectory->load(['professions']);
        }
        return new ProfessionalTrajectoryResource($professionalTrajectory);
    }
}
