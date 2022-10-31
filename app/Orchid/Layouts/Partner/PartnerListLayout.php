<?php

namespace App\Orchid\Layouts\Partner;

use App\Models\Partner;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class PartnerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'partners';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( Partner $partner, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('logo_id', __('Логотип'))
              ->render(function ( Partner $partner ) {
                  $link = $partner->logo?->url() ?? asset(Config::get('constants.avatars.employee.url'));
                  return "<img src='$link' width='100' alt='Логотип компании: $partner->title'>";
              }),

            TD::make('title', __('Название компании'))
              ->render(function ( Partner $partner ) {
                  return Link::make(__("$partner->title"))
                             ->icon('open')
                             ->route('platform.partners.profile', $partner);
              }),

            TD::make("user_id", __('Создано/изменено последним'))
              ->render(function ( Partner $partner ) {
                  return $partner?->user?->name ?? __('Не определено');
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->render(function ( Partner $partner ) {
                  return $partner->updated_at;
              }),

            TD::make(__('Actions'))
              ->width(100)
              ->align(TD::ALIGN_CENTER)
              ->render(function ( Partner $partner ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('open')
                                         ->route('platform.partners.profile', $partner),
                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.partners.edit', $partner),
                                     Button::make(__('Delete'))
                                           ->icon('trash')
                                           ->type(Color::DANGER())
                                           ->method('destroy', ['id' => $partner->id]),
                                 ]);
              }),
        ];
    }
}
