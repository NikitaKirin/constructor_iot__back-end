<?php

namespace App\Orchid\Layouts\Discipline;

use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Semester;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Switcher;
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

            Switcher::make('is_spec')
                    ->popover(__('Спец-дисциплина – дисциплина, который имеет более одной дисциплины. В этот перечень не входят дисциплины с обязательными курсами.'))
                    ->sendTrueOrFalse()
                    ->title('Спец-дисциплина')
                    ->value($this->query->get('discipline.is_spec'))
                    ->placeholder('Является спец-дисциплиной'),

            Input::make('choice_limit')
                 ->type('number')
                 ->title(__('Количество выбираемых курсов'))
                 ->value($this->query->get('discipline.choice_limit')),


            Relation::make('semesters.')
                    ->fromModel(Semester::class, 'text_representation')
                    ->multiple()
                    ->title(__('Семестры'))
                    ->value($this->query->get('discipline')->semesters),

            Relation::make('educationalPrograms.')
                    ->fromModel(EducationalProgram::class, 'title')
                    ->multiple()
                    ->title(__('Образовательные программы'))
                    ->value($this->query->get('discipline')->educationalPrograms),

            Relation::make('courseAssemblies.')
                    ->fromModel(CourseAssembly::class, 'title')
                    ->multiple()
                    ->title(__('Курсовые сборки'))
                    ->value($this->query->get('discipline')->courseAssemblies),

        ];
    }
}
