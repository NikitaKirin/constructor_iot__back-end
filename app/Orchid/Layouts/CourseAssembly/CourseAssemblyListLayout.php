<?php

namespace App\Orchid\Layouts\CourseAssembly;

use App\Models\CourseAssembly;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CourseAssemblyListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'courseAssemblies';


    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [
            TD::make('#')
              ->cantHide()
              ->render(function (CourseAssembly $courseAssembly, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название'))
              ->sort()
              ->render(function (CourseAssembly $courseAssembly ) {
                  return Link::make($courseAssembly->title)
                             ->icon('eye')
                             ->route('platform.courseAssemblies.profile', $courseAssembly);
              }),

            /*TD::make('description', __('Описание'))
              ->width(200),*/

            TD::make('user_id', __("Создано/изменено последним"))
              ->render(function (CourseAssembly $courseAssembly ) {
                  return $courseAssembly->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function (CourseAssembly $courseAssembly ) {
                  return $courseAssembly->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function (CourseAssembly $courseAssembly ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('open')
                                         ->route('platform.courseAssemblies.profile', $courseAssembly),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.courseAssemblies.edit', $courseAssembly),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->method('destroy', ['id' => $courseAssembly->id])
                                           ->canSee(Route::is('platform.courseAssemblies*')),
                                 ]);
              }),
        ];
    }
}
