<?php

namespace App\Orchid\Layouts\AnalyticsCharts\EducationalProgram;

use Orchid\Screen\Layouts\Chart;

class TotalTopEducationalProgramsToMore extends Chart
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

    protected $height = 300;

    protected $title = 'Клик по кнопке "подробнее" у образовательных программ за все время';

    protected $target = 'totalTopEducationalProgramsToMore';
}
