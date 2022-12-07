<?php

namespace App\Orchid\Layouts\EducationalModule;

use App\Orchid\Filters\EducationalModule\ChoiceLimitFilter;
use App\Orchid\Filters\EducationalModule\EducationalDirectionFilter;
use App\Orchid\Filters\EducationalModule\IsSpecFilter;
use App\Orchid\Filters\EducationalModule\SemesterFilter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class EducationalModuleFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable {
        return [
            TitleFilter::class,
            EducationalDirectionFilter::class,
            SemesterFilter::class,
            IsSpecFilter::class,
            ChoiceLimitFilter::class,
        ];
    }
}
