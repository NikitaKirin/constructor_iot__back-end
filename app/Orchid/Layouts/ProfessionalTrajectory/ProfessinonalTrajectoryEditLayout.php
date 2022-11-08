<?php

namespace App\Orchid\Layouts\ProfessionalTrajectory;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class ProfessinonalTrajectoryEditLayout extends Rows
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
    protected function fields(): iterable {
        return [

            Input::make('title')
                 ->type('text')
                 ->title(__('Название'))
                 ->required()
                 ->value($this->query->get('professionalTrajectory.title')),

            Quill::make('description')
                 ->title(__('Описание'))
                 ->toolbar(["text", "color", "header", "list", "format"])
                 ->required()
                 ->value($this->query->get('professionalTrajectory.description') ?? __('Нет описания')),

            Input::make('color')
                 ->type('color')
                 ->title(__("Цвет"))
                 ->required()
                 ->value($this->query->get('professionalTrajectory.color')),
        ];
    }
}
