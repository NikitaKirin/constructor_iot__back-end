<?php

namespace App\Orchid\Layouts\Course;

use App\Orchid\Filters\Course\PartnerFilter;
use App\Orchid\Filters\DisciplineFilter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CourseFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable {
        return [
            TitleFilter::class,
            DisciplineFilter::class,
            PartnerFilter::class,
        ];
    }
}
