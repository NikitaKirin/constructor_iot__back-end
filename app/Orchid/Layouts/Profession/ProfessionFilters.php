<?php

namespace App\Orchid\Layouts\Profession;

use App\Orchid\Filters\Discipline\ProfessionalTrajectoryFilter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProfessionFilters extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TitleFilter::class,
            ProfessionalTrajectoryFilter::class,
        ];
    }
}
