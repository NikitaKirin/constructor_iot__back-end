<?php

namespace App\Orchid\Layouts\Course;

use App\Models\Discipline;
use App\Models\Partner;
use App\Models\Realization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class CourseEditLayout extends Rows
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
                 ->value($this->query->get('course.title')),

            Quill::make('description')
                 ->toolbar(["text", "color", "header", "list", "format"])
                 ->title(__('Описание'))
                 ->required()
                 ->value($this->query->get('course.description')),

            Input::make('limit')
                 ->title(__('Лимит мест'))
                 ->type('integer')
                 ->required()
                 ->value($this->query->get('course.limit')),

            Relation::make('discipline_id')
                    ->title(__('Дисциплина'))
                    ->required()
                    ->fromModel(Discipline::class, 'title')
                    ->value($this->query->get('course')->discipline),

            Relation::make('realization_id')
                    ->title(__('Способ реализации'))
                    ->required()
                    ->fromModel(Realization::class, 'title')
                    ->value($this->query->get('course')->realization),

            Relation::make('partner_id')
                    ->title(__('Партнер'))
                    ->fromModel(Partner::class, 'title')
                    ->value($this->query->get('course')->partner),
        ];
    }
}
