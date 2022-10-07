<?php

namespace App\Orchid\Layouts\Review;

use App\Models\Review;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ReviewListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'reviews';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
              ->render(function ( Review $review, object $loop ) {
                  return ++$loop->index;
              }),

            TD::make('photo_id', __('Фото'))
              ->render(function ( Review $review ) {
                  $link = $review->photo?->url() ?? Config::get('constants.avatar.url');
                  return "<img src='$link' width='100' alt='Фото: $review->author'>";
              }),

            TD::make('author', __('Автор')),

            TD::make('text', __('Текст')),

            TD::make('additional_information',
                __("Дополнительная информация (курс обучения, направление, год выпуска")),

            TD::make('hidden', __('Скрыто'))
              ->render(function ( Review $review ) {
                  return $review->hidden ? __("Да") : __('Нет');
              }),

            TD::make('user_id', __('Сохранено/изменено последним'))
              ->render(function ( Review $review ) {
                  return $review->user?->name ?? __("Не определено");
              }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
              ->render(function ( Review $review ) {
                  return $review->updated_at;
              }),

            TD::make(__('Actions'))
              ->width(100)
              ->align(TD::ALIGN_CENTER)
              ->render(function ( Review $review ) {
                  return DropDown::make()
                                 ->icon('options-vertical')
                                 ->list([
                                     Link::make(__('Открыть'))
                                         ->icon('eye')
                                         ->route('platform.reviews.profile', $review),

                                     Link::make(__('Edit'))
                                         ->icon('pencil')
                                         ->route('platform.reviews.edit', $review),

                                     Button::make(__('Delete'))
                                           ->type(Color::DANGER())
                                           ->icon('trash')
                                           ->method('destroy', ['id' => $review->id]),
                                 ]);
              }),
        ];
    }
}
