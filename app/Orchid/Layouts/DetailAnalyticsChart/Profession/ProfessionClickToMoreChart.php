<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart\Profession;

use Orchid\Screen\Layouts\Chart;

class ProfessionClickToMoreChart extends Chart
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

    protected $title = 'Самые популярные профессии по кликам на кнопку "подробнее" в разделе "Профессии"';

    protected $target = 'professionsClickToMore';

    protected $colors = [
        'ff0032',
    ];
}
