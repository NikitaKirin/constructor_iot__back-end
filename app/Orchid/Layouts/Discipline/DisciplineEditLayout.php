<?php

namespace App\Orchid\Layouts\Discipline;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class DisciplineEditLayout extends Rows
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
                 ->value($this->query->get('discipline.title')),

            Quill::make('description')
                 ->toolbar(["text", "color", "header", "list", "format"])
                 ->title(__('Описание'))
                 ->required()
                 ->value($this->query->get('discipline.description')),

        ];
    }
}
