<?php

namespace App\Orchid\Layouts\FAQ;

use App\Orchid\Filters\FAQ\QuestionFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class FAQFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            QuestionFilter::class,
        ];
    }
}
