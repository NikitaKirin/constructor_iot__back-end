<?php

namespace App\Orchid\Layouts\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Termwind\Components\Li;

class EmployeeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'employees';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->cantHide()
              ->render(function ( Employee $employee, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('photo', __('Фотография'))
              ->render(function ( Employee $employee ) {
                  return "link";
              }),

            TD::make('full_name', __('ФИО'))
              ->sort()
              ->filter()
              ->cantHide(),

            TD::make('email', __('E-mail'))
              ->filter(),

            TD::make('phone_number', __('Номер телефона'))
              ->filter(),

            TD::make('address', __('Адрес')),

            TD::make('audience', __('Аудитория')),

            TD::make('additional_information', __('Дополнительная информация')),

            TD::make('position_id', __('Должность'))
              ->render(function ( Employee $employee ) {
                  return $employee->position->title;
              }),

            TD::make('user_id', __('Создано/изменено последним'))
              ->render(function ( Employee $employee ) {
                  return $employee->user->name ?? 'Не определено';
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->render(function ( Employee $employee ) {
                  return $employee->updated_at;
              }),

            TD::make('actions', __('Действия'))
              ->align(TD::ALIGN_CENTER)
              ->width('100px')
              ->render(function ( Employee $employee ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.employees.edit', $employee),

                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->method('remove', ['id' => $employee->id]),
                                 ]);
              }),
        ];
    }
}
