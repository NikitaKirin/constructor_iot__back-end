<?php

namespace App\Orchid\Layouts\Institute;

use App\Models\Institute;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class InstituteListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'institutes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( Institute $institute, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Полное наименование института'))
              ->sort()
              ->filter(Input::make())
              ->render(function ( Institute $institute ) {
                  return ModalToggle::make($institute->title)
                                    ->modal('asyncEditInstituteModal')
                                    ->modalTitle(__('Новое значение'))
                                    ->method('save')
                                    ->asyncParameters(['institute' => $institute->id]);
              }),

            TD::make('abbreviation', __('Аббревиатура'))
              ->sort()
              ->filter(Input::make())
              ->render(function ( Institute $institute ) {
                  return ModalToggle::make($institute->abbreviation)
                                    ->modal('asyncEditInstituteModal')
                                    ->modalTitle(__('Новое значение'))
                                    ->method('save')
                                    ->asyncParameters(['institute' => $institute->id]);
              })
              ->cantHide(),

            TD::make('user_id', __('Создано/изменено последним'))
              ->render(function ( Institute $institute ) {
                  return $institute->user->name ?? __('Не определено');
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function ( Institute $institute ) {
                  return $institute->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function ( Institute $institute ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     /*ModalToggle::make(__('Edit'))
                                                ->modal('asyncEditInstituteModal')
                                                ->async()
                                                ->method('save')
                                                ->icon('pencil'),*/
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                         //->canSee(((int)$tag->lessons_count === 0) && ((int)$tag->fragments_count
                                         //=== 0))
                                           ->method('remove', ['id' => $institute->id]),
                                 ]);
              }),
        ];
    }
}
