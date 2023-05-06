<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory;

use Orchid\Screen\Layouts\Chart;

class ProfessionalTrajectoryProportionsChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $target = "professionalTrajectoriesProportions";

    protected  $title = "Распределение профессиональных траекторий в долях";

    protected $height = '400';

    protected $description = 'Зависит от количества курсовых сборок, принадлежащих профессиональной траектории';

    protected $maxSlices = 20;
}
