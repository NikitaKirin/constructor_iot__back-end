<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationalModule\EducationalModuleResource;
use App\Http\Resources\Semester\SemesterResourceCollection;
use App\Models\EducationalProgram;
use App\Models\EducationalModule;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EducationalModuleController extends Controller
{
    /**
     * Get the list of educational directions' educational modules
     * Pagination by semesters
     * @param  Request  $request
     * @param  EducationalProgram  $educationalProgram
     */
    public function index(Request $request, EducationalProgram $educationalProgram)
    {
        $data = Semester::whereHas('educationalModules', function (Builder $query) use ($educationalProgram) {
            return $query->whereHas(
                'educationalPrograms',
                fn(Builder $query) => $query->where('id', $educationalProgram->id)
            );
        })->with(['educationalModules.disciplines.professionalTrajectories']);
        if ($request->input('paginate')) {
            return new SemesterResourceCollection($data->paginate(1));
        }
        return new SemesterResourceCollection($data->get());
    }

    public function show(
        Request $request,
        EducationalModule $educationalModule
    ) {
        $withDisciplines = $request->input('withDisciplines');

        if ($withDisciplines) {
            $data = $educationalModule->load(['disciplines', 'disciplines.professionalTrajectories']);
            return new EducationalModuleResource($data);
        }
        return new EducationalModuleResource($educationalModule);
    }
}
