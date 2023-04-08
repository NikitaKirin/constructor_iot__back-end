<?php

namespace App\Orchid\Layouts\CourseAssembly;

use App\Orchid\Filters\CourseAssembly\ProfessionalTrajectoryFilter;
use App\Orchid\Filters\CourseAssembly\SemesterFilter;
use App\Orchid\Filters\DisciplineFilter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CourseAssemblyFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable {
        return [
            TitleFilter::class,
            DisciplineFilter::class,
            SemesterFilter::class,
            ProfessionalTrajectoryFilter::class,
        ];
    }
}
