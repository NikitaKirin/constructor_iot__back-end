<?php

namespace App\Orchid\Layouts\EducationalDirection;

use App\Models\Institute;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class EducationalDirectionEditLayout extends Rows
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
                 ->title(__('Название'))
                 ->placeholder(__('Название'))
                 ->value($this->query->get('educationalDirection.title')),

            Input::make(__('cipher'))
                 ->type('text')
                 ->max(15)
                 ->required()
                 ->title(__('Шифр'))
                 ->placeholder(__('Шифр'))
                 ->value($this->query->get('educationalDirection.cipher')),

            Select::make(__('institute'))
                  ->title(__('Институт'))
                  ->required()
                  ->fromModel(Institute::class, 'abbreviation')
                  ->value($this->query->get('educationalDirections.institute.abbreviation')),
        ];
    }
}
