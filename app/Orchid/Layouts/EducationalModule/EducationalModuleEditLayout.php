<?php

namespace App\Orchid\Layouts\EducationalModule;

use App\Models\Semester;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class EducationalModuleEditLayout extends Rows
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
                 ->value($this->query->get('educationalModule.title')),

            Input::make('choice_limit')
                 ->type('number')
                 ->title(__('Лимит выбора'))
                 ->required()
                 ->value($this->query->get('educationalModule.choice_limit')),

            Relation::make('semesters.')
                    ->fromModel(Semester::class, 'text_representation')
                    ->multiple()
                    ->title(__('Семестры'))
                    ->required()
                    ->value($this->query->get('educationalModule')->semesters),

        ];
    }
}