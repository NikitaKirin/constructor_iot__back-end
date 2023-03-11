<?php

namespace App\Orchid\Layouts\FAQ;

use App\Models\Employee;
use App\Models\FAQ;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class FAQListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'faq';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')->render(fn(FAQ $faq, object $loop) => ++$loop->index),

            TD::make('question', __('Вопрос')),

            TD::make('answer', __('Ответ')),

            TD::make('user_id', __('Создано/изменено последним'))
                ->render(function (FAQ $faq) {
                    return $faq->user->name ?? 'Не определено';
                }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
                ->sort()
                ->render(function (FAQ $faq) {
                    return $faq->updated_at;
                }),

            TD::make('actions', __('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (FAQ $faq) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->icon('pencil')
                                ->route('platform.faq.edit', $faq),

                            Button::make(__('Delete'))
                                ->type(Color::DANGER())
                                ->icon('trash')
                                ->method('remove', ['id' => $faq->id]),
                        ]);
                }),

        ];
    }
}
