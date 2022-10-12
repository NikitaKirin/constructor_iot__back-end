<?php

namespace App\Orchid\Layouts\Discipline;

use App\Models\Discipline;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DisciplineListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'disciplines';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [
            TD::make('#')
              ->cantHide()
              ->render(function ( Discipline $discipline, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название')),

            TD::make('description', __('Описание'))
              ->width(200),

            TD::make('user_id', __("Создано/изменено последним"))
              ->render(function ( Discipline $discipline ) {
                  return $discipline->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->render(function ( Discipline $discipline ) {
                  return $discipline->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function ( Discipline $discipline ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('open')
                                         ->route('platform.disciplines.profile', $discipline),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.disciplines.edit', $discipline),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->method('remove', ['id' => $discipline->id]),
                                 ]);
              }),
        ];
    }
}
