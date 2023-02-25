<?php

namespace App\Orchid\Layouts\Profession;

use App\Models\Profession;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ProfessionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'professions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable {
        return [

            TD::make('#')
                ->render(function (Profession $profession, object $loop) {
                    return ++$loop->index;
                }),

            TD::make('photo_id', __('Фото'))
                ->render(function (Profession $profession) {
                    $link = $profession->photo?->url() ?? asset(Config::get('constants.avatars.student.url'));
                    return "<img src='$link' width='50' alt='Фото: $profession->title'>";
                }),

            TD::make('title', __('Название'))
                ->render(function (Profession $profession) {
                    return Link::make(__("$profession->title"))
                        ->icon('eye')
                        ->route('platform.professions.profile', $profession);
                }),

            TD::make('vacancies_count', __('Количество вакансий на hh.ru по РФ')),

            TD::make('area_vacancies_count', __('Количество вакансий на hh.ru по Области')),

            TD::make('maximal_salary', __('Максимальная зарплата на hh.ru')),

            TD::make('minimal_salary', __('Минимальная зарплата на hh.ru')),

            TD::make('median_salary', __('Медианная зарплата на hh.ru')),

            TD::make('user_id', __('Сохранено/изменено последним'))
                ->render(function (Profession $profession) {
                    return $profession->user?->name ?? __("Не определено");
                }),

            TD::make('updated_at', __('Дата и время последнего изменения'))
                ->sort()
                ->render(function (Profession $profession) {
                    return $profession->updated_at;
                }),

            TD::make(__('Actions'))
                ->width(100)
                ->align(TD::ALIGN_CENTER)
                ->render(function (Profession $profession) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            /*Link::make(__('Открыть'))
                                ->icon('eye')
                                ->route('platform.professions.profile', $profession),*/

                            Link::make(__('Edit'))
                                ->icon('pencil')
                                ->route('platform.professions.edit', $profession),

                            Button::make(__('Delete'))
                                ->type(Color::DANGER())
                                ->icon('trash')
                                ->method('destroy', ['id' => $profession->id]),
                        ]);
                }),
        ];
    }
}
