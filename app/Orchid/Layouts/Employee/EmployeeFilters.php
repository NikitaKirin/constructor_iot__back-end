<?php

namespace App\Orchid\Layouts\Employee;

use App\Orchid\Filters\Employee\PositionFilter;
use App\Orchid\Filters\FullNameFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class EmployeeFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable {
        return [
            FullNameFilter::class,
            PositionFilter::class,
        ];
    }
}
