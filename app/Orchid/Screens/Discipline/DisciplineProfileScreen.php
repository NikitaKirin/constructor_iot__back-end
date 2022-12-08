<?php

namespace App\Orchid\Screens\Discipline;

use App\Models\Discipline;
use App\Orchid\Layouts\Course\CourseListLayout;
use App\Orchid\Layouts\EducationalModule\EducationalModuleListLayout;
use App\Orchid\Layouts\ProfessionalTrajectory\ProfessionalTrajectoryListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DisciplineProfileScreen extends Screen
{
    public Discipline $discipline;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Discipline $discipline ): iterable {
        $discipline->load(['educationalModules', 'professionalTrajectories']);
        return [
            'discipline'               => $discipline,
            'educationalModules'       => $discipline->educationalModules,
            'courses'                  => $discipline->courses,
            'professionalTrajectories' => $discipline->professionalTrajectories,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Дисциплина: {$this->discipline->title}");
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
                ->route("platform.disciplines.edit", $this->discipline),
            Button::make(__("Delete"))
                  ->icon('trash')
                  ->type(Color::DANGER())
                  ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                  ->method('destroy', ['id' => $this->discipline->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::tabs([
                __('Основная информация')         =>
                    Layout::legend("discipline", [
                        Sight::make('title', __('Название')),
                        Sight::make("description", __('Описание'))
                             ->render(function ( Discipline $discipline ) {
                                 return $discipline->description;
                             }),
                    ]),
                __("Курсы дисциплины")            => CourseListLayout::class,
                __("Профессиональные траектории") => ProfessionalTrajectoryListLayout::class,
                __('Образовательные модули')      => EducationalModuleListLayout::class,
            ])
                  ->activeTab(__('Основная информация')),
        ];
    }

    public function destroy( Request $request ): RedirectResponse {
        Discipline::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')));

        return redirect()->route('platform.educationalModules');
    }
}
