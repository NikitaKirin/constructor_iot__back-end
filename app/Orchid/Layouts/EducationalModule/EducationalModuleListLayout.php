<?php

namespace App\Orchid\Layouts\EducationalModule;

use App\Models\EducationalModule;
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

            TD::make('title', __("Название")),

            TD::make('choice_limit', __('Лимит по выбору')),

            TD::make('user_id', __('Создано/изменено последним'))
              ->render(function ( EducationalModule $educationalModule ) {
                  return $educationalModule->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
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
                                         ->icon('open')
                                         ->route('platform.educationalModules.profile', $educationalModule),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.educationalModules.edit', $educationalModule),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->type(Color::DANGER())
                                           ->method('destroy', ['id' => $educationalModule->id]),
                                 ]);
              }),
        ];
    }
}