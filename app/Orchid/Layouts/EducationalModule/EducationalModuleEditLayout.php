<?php

namespace App\Orchid\Layouts\EducationalModule;

use App\Models\Discipline;
use App\Models\EducationalProgram;
use App\Models\Semester;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
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

            Switcher::make('is_spec')
                    ->popover(__('Спецмодуль - модуль, который имеет более одной дисциплины. В этот перечень не входит блок с обязательными курсами.'))
                    ->sendTrueOrFalse()
                    ->title('Спецмодуль')
                    ->value($this->query->get('educationalModule.is_spec'))
                    ->placeholder('Является спецмодулем'),

            Input::make('choice_limit')
                 ->type('number')
                 ->title(__('Лимит выбора - только для спецмодулей'))
                 ->placeholder(__('0 для обычных модулей'))
                 ->value($this->query->get('educationalModule.choice_limit')),


            Relation::make('semesters.')
                    ->fromModel(Semester::class, 'text_representation')
                    ->multiple()
                    ->title(__('Семестры'))
                    ->value($this->query->get('educationalModule')->semesters),

            Relation::make('educationalPrograms.')
                    ->fromModel(EducationalProgram::class, 'title')
                    ->multiple()
                    ->title(__('Образовательные программы'))
                    ->value($this->query->get('educationalModule')->educationalPrograms),

            Relation::make('disciplines.')
                    ->fromModel(Discipline::class, 'title')
                    ->multiple()
                    ->title(__('Дисциплины'))
                    ->value($this->query->get('educationalModule')->disciplines),

        ];
    }
}
