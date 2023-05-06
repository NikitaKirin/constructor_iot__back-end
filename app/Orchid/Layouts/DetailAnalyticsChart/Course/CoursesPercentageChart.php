<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\Course;

use Orchid\Screen\Layouts\Chart;

class CoursesPercentageChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'percentage';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;

    protected $height = 150;

    protected $target = "coursesPercentage";

    protected $title = 'Соотношение университетских и партнерских курсов';
}
