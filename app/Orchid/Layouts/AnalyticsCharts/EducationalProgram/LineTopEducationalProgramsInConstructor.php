<?php

namespace App\Orchid\Layouts\AnalyticsCharts\EducationalProgram;

use Orchid\Screen\Layouts\Chart;

class LineTopEducationalProgramsInConstructor extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $target = 'lineTopEducationalProgramsInConstructor';

    protected $title = 'Топ 3 образовательных программ за последнюю неделю при выборе в конструкторе';

    protected $height = 300;

    /**
     * Configuring line.
     *
     * @var array
     */
    protected $lineOptions = [
        'spline'     => 0,
        'regionFill' => 1,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'heatline'   => 0,
        'dotSize'    => 4,
    ];
}
