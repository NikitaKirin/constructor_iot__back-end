<?php

namespace App\Orchid\Layouts\ProfessionalTrajectory;

use App\Models\ProfessionalTrajectory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Route;

class ProfessionalTrajectoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'professionalTrajectories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( ProfessionalTrajectory $professionalTrajectory, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('title', __('Название трека'))
              ->sort()
              ->filter(Input::make()),

            TD::make('description', __('Описание'))
              ->defaultHidden(),

            TD::make('color', __('Цвет'))
              ->render(function ( ProfessionalTrajectory $professionalTrajectory ) {
                  return Input::make('color')
                              ->type('color')
                              ->value($professionalTrajectory->color)
                              ->disabled();
              }
              )
              ->alignCenter(),

            TD::make('user_id', __('Создано/изменено последним'))
              ->render(function ( ProfessionalTrajectory $professionalTrajectory ) {
                  return $professionalTrajectory->user->name;
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->sort()
              ->render(function ( ProfessionalTrajectory $professionalTrajectory ) {
                  return $professionalTrajectory->updated_at;
              }),

            TD::make(__('Действия'))
              ->cantHide()
              ->render(function ( ProfessionalTrajectory $professionalTrajectory ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     /*Link::make(__('Подробнее'))
                                         ->icon('open')
                                         ->route('platform.professionalTrajectories.profile', $professionalTrajectory),*/
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.professionalTrajectories.edit', $professionalTrajectory),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->type(Color::DANGER())
                                           ->method('destroy', ['id' => $professionalTrajectory->id])
                                           ->canSee(Route::is('platform.professionalTrajectories*')),
                                 ]);
              }),

        ];
    }
}
