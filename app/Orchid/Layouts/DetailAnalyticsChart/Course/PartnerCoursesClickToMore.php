<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\Course;

use Orchid\Screen\Layouts\Chart;

class
PartnerCoursesClickToMore extends Chart
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

    protected $target = 'partnerCoursesClickToMore';

    protected $title = 'Самые популярные курсы при выборе в разделе "Партнерские курсы"';
}
