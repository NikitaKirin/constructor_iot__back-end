<?php

namespace App\Orchid\Layouts\Semester;

use App\Models\Semester;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SemesterListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'semesters';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( Semester $semester, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('text_representation', __('Текстовое представление')),

            TD::make('numerical_representation', __('Числовое представление')),

            TD::make('user_id', __('Создано/Изменено последним'))
              ->render(function ( Semester $semester ) {
                  return $semester->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->render(function ( Semester $semester ) {
                  return $semester->updated_at;
              }),
        ];
    }
}
