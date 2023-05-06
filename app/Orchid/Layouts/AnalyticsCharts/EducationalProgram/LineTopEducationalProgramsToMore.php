<?php

namespace App\Orchid\Layouts\AnalyticsCharts\EducationalProgram;

use Orchid\Screen\Layouts\Chart;

class LineTopEducationalProgramsToMore extends Chart
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

    protected $target = 'lineTopEducationalProgramsToMore';

    protected $title = 'Топ 3 образовательных программ за последнюю неделю c переходом на страницу программы';

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
