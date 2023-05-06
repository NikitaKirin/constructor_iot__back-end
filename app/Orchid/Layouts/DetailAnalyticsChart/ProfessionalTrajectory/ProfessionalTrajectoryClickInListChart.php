<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory;

use Orchid\Screen\Layouts\Chart;

class ProfessionalTrajectoryClickInListChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $target = "professionalTrajectoriesClickInList";

    protected $title = 'Самые популярные траектории при выборе из готового списка';

    protected $colors = [
        '3eff25',
    ];
}
