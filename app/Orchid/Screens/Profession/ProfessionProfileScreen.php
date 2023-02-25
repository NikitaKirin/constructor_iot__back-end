<?php

namespace App\Orchid\Screens\Profession;

use App\Models\Profession;
use App\Orchid\Layouts\ProfessionalTrajectory\ProfessionalTrajectoryListLayout;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ProfessionProfileScreen extends Screen
{
    public Profession $profession;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Profession $profession): iterable {
        $profession->load(['professionalTrajectories', 'photo']);
        return [
            'profession' => $profession,
            'professionalTrajectories' => $profession->professionalTrajectories,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("{$this->profession->title}");
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Edit'))
                ->icon("pencil")
                ->route("platform.professions.edit", $this->profession),
            Button::make(__("Delete"))
                ->icon('trash')
                ->type(Color::DANGER())
                ->confirm(__("Вы уверены, что хотите удалить данную профессию? Данное действие нельзя будет отменить."))
                ->method('destroy', ['id' => $this->profession->id]),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::tabs([
                __("Основная информация") =>
                    Layout::legend('profession', [
                        Sight::make('photo_id', __('Фото'))
                            ->render(function () {
                                $link = $this->profession?->photo?->url() ?? asset(
                                    Config::get('constants.avatars.employee.url')
                                );
                                return "<img src='$link' width='100' alt='Логотип компании: {$this->profession->title}'";
                            }),
                        Sight::make('title', __('Название профессии')),
                        Sight::make('description', __("Описание")),
                        Sight::make('headHunter_title', __('Поисковая фраза для сервиса HeadHunter'))
                            ->popover(__("Используется для поиска вакансий")),
                        Sight::make('vacancies_count', __('Количество вакансий по данным HeadHunter по РФ')),
                        Sight::make('area_vacancies_count', __('Количество вакансий по данным HeadHunter по Области')),
                        Sight::make('maximal_salary', __('Максимальная зарплата по данным HeadHunter')),
                        Sight::make('minimal_salary', __('Минимальная зарплата по данным HeadHunter')),
                        Sight::make('median_salary', __('Медианная зарплата по данным HeadHunter')),
                    ]),
                __("Профессиональные траектории") => ProfessionalTrajectoryListLayout::class,
            ])
        ];
    }
}
