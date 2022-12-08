<?php

namespace App\Orchid\Layouts\EducationalModule;

use App\Models\EducationalModule;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class EducationalModuleListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'educationalModules';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( EducationalModule $educationalModule, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __("Название"))
              ->sort()
              ->render(function ( EducationalModule $educationalModule ) {
                  return Link::make($educationalModule->title)
                             ->icon('eye')
                             ->route('platform.educationalModules.profile', $educationalModule);
              }),

            TD::make('choice_limit', __('Лимит по выбору дисциплин'))
              ->popover(__('Сколько дисциплин выбирают студенты в данном модуле'))
              ->sort()
                //->width('100px')
              ->alignCenter(),

            TD::make('is_spec', __('Спецмодуль'))
              ->sort()
              ->alignCenter()
              ->render(function ( EducationalModule $educationalModule ) {
                  return $educationalModule->is_spec ? __('Да') : ('Нет');
              }),

            TD::make('user_id', __('Создано/изменено последним'))
              ->alignCenter()
              ->render(function ( EducationalModule $educationalModule ) {
                  return $educationalModule->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->alignCenter()
              ->render(function ( EducationalModule $educationalModule ) {
                  return $educationalModule->updated_at;
              }),

            TD::make(__('Actions'))
              ->width(100)
              ->align(TD::ALIGN_CENTER)
              ->render(function ( EducationalModule $educationalModule ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('eye')
                                         ->route('platform.educationalModules.profile', $educationalModule),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.educationalModules.edit', $educationalModule),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->type(Color::DANGER())
                                           ->method('destroy', ['id' => $educationalModule->id])
                                           ->canSee(Route::is('platform.educationalModules*')),
                                 ]);
              }),
        ];
    }
}
