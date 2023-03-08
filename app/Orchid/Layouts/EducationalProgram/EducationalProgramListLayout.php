<?php

namespace App\Orchid\Layouts\EducationalProgram;

use App\Models\EducationalProgram;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EducationalProgramListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'educationalPrograms';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [
            TD::make('#')
              ->cantHide()
              ->render(function (EducationalProgram $educationalProgram, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название'))
              ->filter(Input::make())
              ->sort()
              ->render(function (EducationalProgram $educationalProgram ) {
                  return ModalToggle::make($educationalProgram->title)
                                    ->modal('asyncEducationalProgramModal')
                                    ->modalTitle(__('Новое значение'))
                                    ->method('save')
                                    ->asyncParameters(['educationalProgram' => $educationalProgram->id]);
              }),

            TD::make('institute_id', __('Институт'))
              ->filter()
              ->render(function (EducationalProgram $educationalProgram ) {
                  return $educationalProgram->institute->abbreviation;
              }),

            TD::make('user_id', __("Создано/изменено последним"))
              ->render(function (EducationalProgram $educationalProgram ) {
                  return $educationalProgram->user->name ?? __('Не определено');
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function (EducationalProgram $educationalProgram ) {
                  return $educationalProgram->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function (EducationalProgram $educationalProgram ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->method('remove', ['id' => $educationalProgram->id]),
                                 ]);
              }),

        ];
    }
}
