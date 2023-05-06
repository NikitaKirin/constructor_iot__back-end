<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory;

use Orchid\Screen\Layouts\Chart;

class ProfessionalTrajectoryClickInConstructorChart extends Chart
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

    protected $target = "professionalTrajectoriesClickInConstructor";

    protected $title = "Самые популярные траектории, сформированные после выбора в конструкторе";
}
