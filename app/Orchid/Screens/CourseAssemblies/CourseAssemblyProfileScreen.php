<?php

namespace App\Orchid\Screens\CourseAssemblies;

use App\Models\CourseAssembly;
use App\Orchid\Layouts\Course\CourseListLayout;
use App\Orchid\Layouts\Discipline\DisciplineListLayout;
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

class CourseAssemblyProfileScreen extends Screen
{
    public CourseAssembly $courseAssembly;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(CourseAssembly $courseAssembly): iterable {
        $courseAssembly->load(['discipline', 'professionalTrajectories']);
        return [
            'courseAssembly'           => $courseAssembly,
            'discipline'              => $courseAssembly->discipline,
            'courses'                  => $courseAssembly->courses,
            'professionalTrajectories' => $courseAssembly->professionalTrajectories,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Курсовая сборка: {$this->courseAssembly->title}");
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
                ->route("platform.courseAssemblies.edit", $this->courseAssembly),
            Button::make(__("Delete"))
                ->icon('trash')
                ->type(Color::DANGER())
                ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                ->method('destroy', ['id' => $this->courseAssembly->id]),
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
                    Layout::legend("courseAssembly", [
                        Sight::make('title', __('Название')),
                        Sight::make("description", __('Описание'))
                            ->render(function (CourseAssembly $courseAssembly) {
                                return $courseAssembly->description;
                            }),
                        Sight::make("educational_program", __('Образовательная программа'))
                        ->render(function (CourseAssembly $courseAssembly){
                            return $courseAssembly->discipline->educationalProgram()->first()->title;
                        }),
                        Sight::make("discipline", __('Дисциплина'))
                            ->render(function (CourseAssembly $courseAssembly){
                                return $courseAssembly->discipline->title;
                            }),
                    ]),
                __("Курсы")                       => CourseListLayout::class,
                __("Профессиональные траектории") => ProfessionalTrajectoryListLayout::class,
            ])
                ->activeTab(__('Основная информация')),
        ];
    }

    public function destroy(Request $request): RedirectResponse {
        CourseAssembly::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')));

        return redirect()->route('platform.disciplines');
    }
}
