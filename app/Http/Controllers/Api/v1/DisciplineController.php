<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Discipline\DisciplineResource;
use App\Http\Resources\Semester\SemesterResourceCollection;
use App\Models\Discipline;
use App\Models\EducationalProgram;
use App\Models\EducationalModule;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    /**
     * Get the list of educational directions' disciplines
     * Pagination by semesters
     * @param  Request  $request
     * @param  EducationalProgram  $educationalProgram
     */
    public function index(Request $request, EducationalProgram $educationalProgram)
    {
        $data = Semester::whereHas('disciplines', function (Builder $query) use ($educationalProgram) {
            return $query->whereHas(
                'educationalPrograms',
                fn(Builder $query) => $query->where('id', $educationalProgram->id)
            );
        })->with(['disciplines.courseAssemblies.professionalTrajectories'])->orderBy('numerical_representation');
        if ($request->input('paginate')) {
            return new SemesterResourceCollection($data->paginate(1));
        }
        return new SemesterResourceCollection($data->get());
    }

    public function show( Request $request, Discipline $discipline) {
        $withCourseAssemblies = $request->input('withCourseAssemblies');

        if ($withCourseAssemblies) {
            $data = $discipline->load(['courseAssemblies', 'courseAssemblies.professionalTrajectories']);
            return new DisciplineResource($data);
        }
        return new DisciplineResource($discipline);
    }
}
