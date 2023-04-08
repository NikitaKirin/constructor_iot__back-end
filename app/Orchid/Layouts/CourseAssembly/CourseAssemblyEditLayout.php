<?php

namespace App\Orchid\Layouts\CourseAssembly;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class CourseAssemblyEditLayout extends Rows
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
                 ->value($this->query->get('courseAssembly.title')),

            Quill::make('description')
                 ->toolbar(["text", "color", "header", "list", "format"])
                 ->title(__('Описание'))
                 ->required()
                 ->value($this->query->get('courseAssembly.description') ?? __('Описания нет')),

        ];
    }
}
