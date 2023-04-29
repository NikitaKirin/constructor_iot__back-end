<?php

namespace App\Orchid\Screens\Discipline;

use App\Models\Discipline;
use App\Orchid\Layouts\CourseAssembly\CourseAssemblyListLayout;
use App\Orchid\Layouts\EducationalProgram\EducationalProgramListLayout;
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
    public function query(Discipline $discipline ): iterable {
        $discipline->load(['educationalPrograms', 'courseAssemblies']);
        return [
            'discipline'     => $discipline,
            'educationalPrograms' => $discipline->educationalPrograms,
            'courseAssemblies'   => $discipline->courseAssemblies,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __( "Дисциплина: {$this->discipline->title}");
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
                  ->confirm(__("Вы уверены, что хотите удалить дисциплину? Данное действие нельзя будет отменить."))
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
                __('Образовательные программы') => EducationalProgramListLayout::class,
                __('Основная информация') =>
                    Layout::legend("discipline", [
                        Sight::make('title', __('Название')),
                        Sight::make("choice_limit", __('Лимит выбора')),
                        Sight::make('is_spec', __('Спец-дисциплина'))
                             ->render(function (Discipline $discipline ) {
                                 return $discipline->is_spec ? 'Да' : 'Нет';
                             }),
                    ]),

                __("Курсовые сборки дисциплины") => CourseAssemblyListLayout::class,
            ])
                  ->activeTab(__('Основная информация')),
        ];
    }

    public function destroy( Request $request ): RedirectResponse {
        Discipline::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')));

        return redirect()->route('platform.disciplines');
    }
}
