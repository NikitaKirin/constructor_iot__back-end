<?php

namespace App\Orchid\Layouts\AnalyticsCharts\EducationalProgram;

use Orchid\Screen\Layouts\Chart;

class TotalTopEducationalProgramsInConstructor extends Chart
{
    /**
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

    protected $target = 'totalTopEducationalProgramsInConstructor';

    protected $title = 'Топ образовательных программ, выбираемых в конструкторе за все время';
}
