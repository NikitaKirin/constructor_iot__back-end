<?php

namespace App\Orchid\Screens\Course;

use App\Models\Course;
use App\Models\Discipline;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;

class CourseProfileScreen extends Screen
{
    public Course $course;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Course $course ): iterable {
        return [
            'course' => $course,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Курс: {$this->course->title}");
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Edit'))
                ->icon("pencil")
                ->route("platform.courses.edit", $this->course),
            Button::make(__("Delete"))
                ->icon('trash')
                ->type(Color::DANGER())
                ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                ->method('destroy', ['id' => $this->course->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            \Orchid\Support\Facades\Layout::tabs([
                __('Основная информация') => [
                    \Orchid\Support\Facades\Layout::legend('course', [
                        Sight::make('title', __("Название")),
                        Sight::make('description', __('Описание'))
                            ->render(function (Course $course){
                                return $course->description;
                            }),
                        Sight::make('limit', __('Лимит мест')),
                        Sight::make('discipline_id', __("Дисциплина"))
                            ->render(function (Course $course){
                                $discipline = $course->discipline;
                                if ($discipline->title === __("Нет")) {
                                    return $discipline->title;
                                }
                                return Link::make($discipline->title)
                                    ->icon('eye')
                                    ->route('platform.disciplines.profile', $discipline);
                            }),
                        Sight::make('partner_id', __('Партнер'))
                            ->render(function (Course $course){
                                $partner = $course->partner;
                                if ($partner->title === __("Нет")) {
                                    return $partner->title;
                                }
                                return Link::make($partner->title)
                                    ->icon('eye')
                                    ->route('platform.partners.profile', $partner);
                            }),
                        Sight::make('realization_id', __('Вид реализации')),
                    ]),
                ],
            ]),
        ];
    }
}
