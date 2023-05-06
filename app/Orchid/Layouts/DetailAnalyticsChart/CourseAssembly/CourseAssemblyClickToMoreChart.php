<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\CourseAssembly;

use Orchid\Screen\Layouts\Chart;

class CourseAssemblyClickToMoreChart extends Chart
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

    protected $title = 'Самые популярные курсовые сборки по кликам на кнопку "подробнее"';

    protected $target = 'courseAssembliesClickToMore';

    protected $colors = [
        '#ffaaee',
    ];
}
