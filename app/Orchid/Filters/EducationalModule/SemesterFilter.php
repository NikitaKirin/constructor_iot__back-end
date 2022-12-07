<?php

namespace App\Orchid\Filters\EducationalModule;

use App\Orchid\Filters\Discipline\SemesterFilter as DisciplineSemesterFilter;
use Illuminate\Database\Eloquent\Builder;

class SemesterFilter extends DisciplineSemesterFilter
{
    public function name(): string {
        return __("Семестры");
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run( Builder $builder ): Builder {
        return $builder->whereHas('semesters', function ( Builder $query ) {
            return $query->whereIntegerInRaw('semester_id', $this->request->input('semesters'));
        });
    }
}
