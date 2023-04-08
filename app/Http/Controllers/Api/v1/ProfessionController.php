<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profession\ProfessionResource;
use App\Http\Resources\Profession\ProfessionResourceCollection;
use App\Models\Profession;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index(Request $request) {
        $withProfessionalTrajectories = $request->boolean('withProfessionalTrajectories');
        $professionalTrajectories = $request->input('professionalTrajectories', default: false);
        $professionTitle = $request->input('professionTitle', default: false);
        $educationalPrograms = $request->input('educationalPrograms');
        $paginate = $request->integer('paginate', default: 10);
        $professionsQuery = Profession::query();
        if ($withProfessionalTrajectories) {
            $professionsQuery->with('professionalTrajectories');
        }
        $professionsQuery->when($professionalTrajectories, function (Builder $query) use ($professionalTrajectories) {
            return $query->whereHas('professionalTrajectories',
                fn(Builder $query) => $query->whereIntegerInRaw('professional_trajectory_id', $professionalTrajectories));
        });
        $professionsQuery->when($professionTitle, fn(Builder $query) => $query->where('title', 'ILIKE', '%' . $professionTitle . '%'));
        $professionsQuery->when($educationalPrograms, function (Builder $query) use ($educationalPrograms) {
            return $query->whereHas('professionalTrajectories.courseAssemblies.disciplines.educationalPrograms',
                fn(Builder $query) => $query->whereIntegerInRaw('educational_program_id', $educationalPrograms));
        });
        $professionsQuery = $this->setSorting($professionsQuery, $request);
        return new ProfessionResourceCollection($professionsQuery->paginate($paginate));
    }

    public function show(Profession $profession, Request $request) {
        $withProfessionalTrajectories = $request->boolean('withProfessionalTrajectories');
        if ($withProfessionalTrajectories) {
            return new ProfessionResource($profession->load('professionalTrajectories'));
        }
        return new ProfessionResource($profession);
    }

    private function setSorting(Builder $query, Request $request): Builder {
        if ($sortBy = $request->input('sortBySalary')) {
            if ($sortBy === 'asc' || $sortBy === 'desc') {
                $query->orderBy('median_salary', $sortBy);
            }
        } elseif ($sortBy = $request->input('sortByVacancyCount')) {
            if ($sortBy === 'asc' || $sortBy === 'desc') {
                $query->orderBy('vacancies_count', $sortBy);
            }
        } else {
            $query->orderBy('title');
        }
        return $query;
    }
}
