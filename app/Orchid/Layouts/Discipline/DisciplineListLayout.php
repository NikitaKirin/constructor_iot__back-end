<?php

namespace App\Orchid\Layouts\Discipline;

use App\Models\Discipline;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

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
              ->render(function (Discipline $discipline, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __("Название"))
              ->sort()
              ->render(function (Discipline $discipline ) {
                  return Link::make($discipline->title)
                             ->icon('eye')
                             ->route('platform.disciplines.profile', $discipline);
              }),

            TD::make('choice_limit', __('Лимит по выбору курсов'))
              ->popover(__('Сколько курсов выбирают студенты в данной дисциплине'))
              ->sort()
              ->alignCenter(),

            TD::make('is_spec', __('Спец-дисциплина'))
              ->sort()
              ->alignCenter()
              ->render(function (Discipline $discipline ) {
                  return $discipline->is_spec ? __('Да') : ('Нет');
              }),

            TD::make('user_id', __('Создано/изменено последним'))
              ->alignCenter()
              ->render(function (Discipline $discipline ) {
                  return $discipline->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->alignCenter()
              ->render(function (Discipline $discipline ) {
                  return $discipline->updated_at;
              }),

            TD::make(__('Actions'))
              ->width(100)
              ->align(TD::ALIGN_CENTER)
              ->render(function (Discipline $discipline ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('eye')
                                         ->route('platform.disciplines.profile', $discipline),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.disciplines.edit', $discipline),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->type(Color::DANGER())
                                           ->method('destroy', ['id' => $discipline->id])
                                           ->canSee(Route::is('platform.disciplines*')),
                                 ]);
              }),
        ];
    }
}
