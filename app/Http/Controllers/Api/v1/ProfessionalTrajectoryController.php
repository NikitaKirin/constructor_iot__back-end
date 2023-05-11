<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionalTrajectory\IndexProfessionalTrajectoryRequest;
use App\Http\Requests\ProfessionalTrajectory\ShowProfessionalTrajectoryRequest;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProfessionalTrajectoryController extends Controller
{

    public function index(IndexProfessionalTrajectoryRequest $request) {
        $validatedFields = collect($request->validated());
        $professionalTrajectoryQuery = ProfessionalTrajectory::query()->with(['icons']);
        if ($educationalProgramId = $validatedFields->get('educational_program_id')) {
            $professionalTrajectoryQuery->whereHas('courseAssemblies.discipline.educationalPrograms',
                fn(Builder $builder) => $builder->where('id', $educationalProgramId)
            );
        }
        if ($validatedFields->get('loadProfessions')) {
            $professionalTrajectoryQuery = $professionalTrajectoryQuery->with(['professions']);
        }
        return new ProfessionalTrajectoryResourceCollection($professionalTrajectoryQuery->orderBy('title')->get());
    }

    public function show(ProfessionalTrajectory $professionalTrajectory, ShowProfessionalTrajectoryRequest $request) {
        $validatedFields = collect($request->validated());
        $professionalTrajectory->load(['icons']);
        if ($validatedFields->get('loadCourseAssembliesCount')) {
            $professionalTrajectory->loadCount('courseAssemblies');
        }
        if ($validatedFields->get('loadProfessions')) {
            $professionalTrajectory->load(['professions']);
        }
        return new ProfessionalTrajectoryResource($professionalTrajectory);
    }
}
