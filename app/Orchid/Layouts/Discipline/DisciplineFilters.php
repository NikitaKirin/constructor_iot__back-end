<?php

namespace App\Orchid\Layouts\Discipline;

use App\Orchid\Filters\Discipline\ProfessionalTrajectoryFilter;
use App\Orchid\Filters\Discipline\SemesterFilter;
use App\Orchid\Filters\EducationalModuleFilter;
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
            EducationalModuleFilter::class,
            SemesterFilter::class,
            ProfessionalTrajectoryFilter::class,
        ];
    }
}
