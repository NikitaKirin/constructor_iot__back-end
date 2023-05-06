<?php

namespace App\Orchid\Layouts\DetailAnalyticsChart;

use App\Models\EducationalProgram;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class FiltersLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Select::make('educational_program_id')
            ->title('Образовательная программа')
            ->fromModel(EducationalProgram::class, 'title')
            ->value($this->query->get('educationalProgramId')),

            DateRange::make('period')
            ->title('Период')
            ->value($this->query->get('period') || null),
        ];
    }
}
