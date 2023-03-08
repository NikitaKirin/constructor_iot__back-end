<?php

namespace App\Orchid\Layouts\EducationalProgram;

use App\Models\Institute;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class EducationalProgramEditLayout extends Rows
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
            Input::make(__('title'))
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Название'))
                ->placeholder(__('Название'))
                ->value($this->query->get('educationalProgram.title')),

            Input::make(__('educational_direction'))
                ->type('text')
                ->max(15)
                ->required()
                ->title(__('Направление подготовки'))
                ->placeholder(__('Направление подготовки'))
                ->value($this->query->get('educationalProgram.educational_direction')),

            Matrix::make('passing_scores')
                ->title(__('Проходной балл прошлого года'))
                ->columns([
                    'Год' => 'year',
                    'Проходной балл' => 'passing_score',
                ])
                ->fields([
                    'year' => DateTimer::make()
                        ->allowInput()
                        ->format('Y'),
                    'passing_score' => Input::make()
                        ->type('number')
                        ->min(0),
                ])
                ->value($this->query->get('educationalProgram.passing_scores'))
                ->maxRows(1),

            Input::make('training_period')
                ->type('text')
                ->title('Срок обучения')
                ->value($this->query->get('educationalProgram.training_period'))
                ->required(),

            Input::make('budget_places')
                ->type('number')
                ->title('Количество бюджетных мест')
                ->value($this->query->get('educationalProgram.budget_places'))
                ->required(),

            Select::make(__('institute'))
                ->title(__('Институт'))
                ->required()
                ->fromModel(Institute::class, 'abbreviation')
                ->value($this->query->get('educationalProgram.institute.abbreviation')),

            Input::make('page_link')
                ->type('text')
                ->title(__('Ссылка на образовательную программу'))
                ->required()
                ->value($this->query->get('educationalProgram.page_link')),
        ];
    }
}
