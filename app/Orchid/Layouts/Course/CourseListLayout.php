<?php

namespace App\Orchid\Layouts\Course;

use App\Models\Course;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class CourseListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'courses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( Course $course, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название'))
              ->sort()
              ->width(250),

            /*TD::make('description', __('Описание'))
              ->width(200),*/

            TD::make('limit', __('Лимит мест'))
              ->sort(),

            TD::make('discipline_id', __("Дисциплина"))
              ->render(function ( Course $course ) {
                  return $course->discipline?->title ?? __('Не определено');
              }),

            TD::make('realization_id', __('Вид реализации'))
              ->render(function ( Course $course ) {
                  return $course->realization->title;
              })
              ->defaultHidden(),

            TD::make('partner_id', __('Партнер'))
              ->render(function ( Course $course ) {
                  return $course->partner->title;
              })
              ->defaultHidden(),

            TD::make('user_id', __('Сохранено/изменено последним'))
              ->render(function ( Course $course ) {
                  return $course->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function ( Course $course ) {
                  return $course->updated_at;
              }),

            TD::make(__('Actions'))
              ->width(100)
              ->align(TD::ALIGN_CENTER)
              ->render(function ( Course $course ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('eye')
                                         ->route('platform.courses.profile', $course),

                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.courses.edit', $course),

                                     Button::make(__('Delete'))
                                           ->type(Color::DANGER())
                                           ->icon('trash')
                                           ->method('destroy', ['id' => $course->id]),
                                 ]);
              }),
        ];

    }
}
