<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\Course;

use Orchid\Screen\Layouts\Chart;

class PartnerCoursesProportionsChart extends Chart
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

    protected $target = 'partnerCoursesProportions';

    protected $title = "Распределение партнерских курсов";

    protected $maxSlices = "20";

    protected $height = "500";
}
