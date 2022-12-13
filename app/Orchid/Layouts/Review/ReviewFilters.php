<?php

namespace App\Orchid\Layouts\Review;

use App\Orchid\Filters\Review\AuthorFilter;
use App\Orchid\Filters\Review\EducationalDirectionFilter;
use App\Orchid\Filters\Review\HiddenFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ReviewFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            AuthorFilter::class,
            EducationalDirectionFilter::class,
            HiddenFilter::class,
        ];
    }
}
