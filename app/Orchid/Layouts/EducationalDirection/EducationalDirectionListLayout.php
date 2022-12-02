<?php

namespace App\Orchid\Layouts\EducationalDirection;

use App\Models\EducationalDirection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EducationalDirectionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'educationalDirections';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [
            TD::make('#')
              ->cantHide()
              ->render(function ( EducationalDirection $educationalDirection, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название'))
              ->filter(Input::make())
              ->sort()
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return ModalToggle::make($educationalDirection->title)
                                    ->modal('asyncEditEducationalDirectionModal')
                                    ->modalTitle(__('Новое значение'))
                                    ->method('save')
                                    ->asyncParameters(['educationalDirection' => $educationalDirection->id]);
              }),

            TD::make('cipher', __('Шифр'))
              ->sort()
              ->filter(Input::make())
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return ModalToggle::make($educationalDirection->cipher)
                                    ->modal('asyncEditEducationalDirectionModal')
                                    ->modalTitle(__('Новое значение'))
                                    ->method('save')
                                    ->asyncParameters(['educationalDirection' => $educationalDirection->id]);
              }),

            TD::make('institute_id', __('Институт'))
              ->filter()
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return $educationalDirection->institute->abbreviation;
              }),

            TD::make('user_id', __("Создано/изменено последним"))
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return $educationalDirection->user->name ?? __('Не определено');
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return $educationalDirection->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function ( EducationalDirection $educationalDirection ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->method('remove', ['id' => $educationalDirection->id]),
                                 ]);
              }),

        ];
    }
}
