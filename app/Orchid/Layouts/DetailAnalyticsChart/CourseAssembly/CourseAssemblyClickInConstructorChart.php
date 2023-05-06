<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\CourseAssembly;

use Orchid\Screen\Layouts\Chart;

class CourseAssemblyClickInConstructorChart extends Chart
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

    protected $target = 'courseAssembliesClickInConstructor';

    protected $title = 'Самые популярные курсовые сборки при выборе в конструкторе';

    protected $colors = [
        '#ffa700',
    ];
}
