<?php

namespace App\Orchid\Layouts\Course;

use App\Models\Realization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Upload;
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
                ->value($this->query->get('course.description') ?? __('Описания нет')),

            Relation::make('realization_id')
                ->title(__('Способ реализации'))
                ->required()
                ->fromModel(Realization::class, 'title')
                ->value($this->query->get('course')->realization),

            Upload::make('video_id')
                ->title(__('Видео'))
                ->targetId()
                ->maxFiles(1)
                ->acceptedFiles('video/*')
                ->value($this->query->get('course')->video_id),

            Upload::make('presentation_id')
                ->title(__('Презентация'))
                ->targetId()
                ->maxFiles(1)
                ->acceptedFiles('.pdf,.pptx,.ppt')
                ->value($this->query->get('course')->presentation_id),

            Upload::make('documents')
                ->groups('documents')
                ->title(__('Другие документы'))
                ->maxFiles(10)
                ->acceptedFiles('.pdf,.pptx,.ppt,.rtf,.doc,.docx,.doc,.xls,.xlsx')
                ->value($this->query->get('course')->documents),
        ];
    }
}
