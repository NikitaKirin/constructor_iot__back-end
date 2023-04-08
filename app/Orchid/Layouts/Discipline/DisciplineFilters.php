<?php

namespace App\Orchid\Layouts\Discipline;

use App\Orchid\Filters\Discipline\ChoiceLimitFilter;
use App\Orchid\Filters\Discipline\EducationalProgramFilter;
use App\Orchid\Filters\Discipline\IsSpecFilter;
use App\Orchid\Filters\Discipline\SemesterFilter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DisciplineFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable {
        return [
            TitleFilter::class,
            EducationalProgramFilter::class,
            SemesterFilter::class,
            IsSpecFilter::class,
            ChoiceLimitFilter::class,
        ];
    }
}
