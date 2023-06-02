<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\Profession;

use Orchid\Screen\Layouts\Chart;

class ProfessionMedianSalaryBarChart extends Chart
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

    protected  $height = 300;

    protected $target = 'professionMedianSalaries';

    protected $title = 'Сравнение медианной заработной платы профессий';
}
