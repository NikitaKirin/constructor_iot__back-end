<?php

namespace App\Orchid\Layouts\Institute;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class InstituteEditLayout extends Rows
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
            Input::make(__('title'))
                 ->type('text')
                 ->max(255)
                 ->required()
                 ->title(__('Полное название'))
                 ->placeholder(__('Полное название'))
                 ->value($this->query->get('institute.title')),

            Input::make(__('abbreviation'))
                 ->type('text')
                 ->max(15)
                 ->required()
                 ->title(__('Аббревиатура'))
                 ->placeholder(__('Аббревиатура'))
                 ->value($this->query->get('institute.abbreviation')),
        ];
    }
}
