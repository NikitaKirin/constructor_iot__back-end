<?php

namespace App\Orchid\Screens\CourseAssemblies;

use App\Http\Requests\CourseAssembly\CreateCourseAssemblyRequest;
use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\CourseAssemblyLevel;
use App\Models\Discipline;
use App\Models\ProfessionalTrajectory;
use App\Orchid\Layouts\CourseAssembly\CourseAssemblyEditLayout;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CourseAssemblyEditScreen extends Screen
{
    public CourseAssembly $courseAssembly;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(CourseAssembly $courseAssembly ): iterable {
        $courseAssembly->load(['discipline', 'courses', 'professionalTrajectories']);
        return [
            'courseAssembly' => $courseAssembly,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->courseAssembly->exists ? __("Обновить курсовую сборку: {$this->courseAssembly->title}") : __("Создать новую курсовую сборку");
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Button::make(__('Delete'))
                  ->icon('trash')
                  ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                  ->type(Color::DANGER())
                  ->canSee($this->courseAssembly->exists)
                  ->method('remove', ['id' => $this->courseAssembly->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     * @throws BindingResolutionException
     */
    public function layout(): iterable {
        return [
            Layout::block(CourseAssemblyEditLayout::class)
                  ->title(__('Основная информация'))
                  ->description(__('Обновите информацию о курсовой сборке, заполнив соответсвующее поля.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

            Layout::block([
                Layout::rows([
                    Relation::make('discipline')
                            ->required()
                            ->fromModel(Discipline::class, 'title')
                            ->displayAppend('WithEducationalProgram')
                            ->value($this->courseAssembly->discipline)
                            ->title(__('Дисциплина')),
                ]),
            ])
                  ->title(__('Дисциплина'))
                  ->description(__('Выберите дисциплину, к которой принадлежит данная сборка, из предложенного списка'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Link::make(__('Создать новую дисциплину'))
                          ->icon('plus')
                          ->target('_blank')
                          ->route('platform.disciplines.create'),
                  ]),


            Layout::block([
                Layout::rows([
                    Relation::make('courses.')
                            ->required()
                            ->fromModel(Course::class, 'title')
                            ->multiple()
                            ->value($this->courseAssembly->courses)
                            ->title(__('Список курсов')),
                ]),
            ])
                  ->title(__('Курсы'))
                  ->description(__('Выберите курсы, которые принадлежат данной курсовой сборке, из предложенного списка'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Link::make(__('Создать новый курс'))
                          ->icon('plus')
                          ->route('platform.courses.create')
                          ->target('_blank'),
                  ]),

            Layout::block([
                Layout::rows([
                    Matrix::make('trajectories_levels')
                          ->title(__('Оценивание'))
                          ->columns([
                              'Профессиональная траектория' => 'professional_trajectory',
                              'Оценка сборки для траектории' => 'course_assembly_level',
                          ])
                          ->fields([
                              'professional_trajectory' => Select::make('professional_trajectory')
                                                                 ->fromModel(ProfessionalTrajectory::class, 'title'),
                              'course_assembly_level'   => Select::make('course_assembly_level')
                                                                 ->fromModel(CourseAssemblyLevel::class, 'title',
                                                                     'digital_value'),
                          ])
                        //->canSee($this->discipline->professionalTrajectories()->exists())
                          ->value($this->getJsonForCourseAssemblyLevelsField()),
                ]),
            ])
                  ->title(__('Профессиональные траектории'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Link::make(__('Создать новую траекторию'))
                          ->icon('plus')
                          ->route('platform.professionalTrajectories.create')
                          ->target('_blank'),
                  ]),
        ];
    }

    public function save(CourseAssembly $courseAssembly, CreateCourseAssemblyRequest $request ) {

        $trajectories = collect($request->input('trajectories_levels', []))
            ->unique('professional_trajectory')
            ->keyBy('professional_trajectory')
            ->map(fn( $item ) => ['course_assembly_level_digital_value' => $item['course_assembly_level']]);

        $courseAssembly->fill($request->validated())
                   ->user()->associate(Auth::user())
                   ->save();

        $courseAssembly->discipline()->associate($request->input('discipline'))->save();

        $courseAssembly->professionalTrajectories()
                   ->sync($trajectories);

        $courseAssembly->courses()->sync($request->input('courses', []));

        Toast::success(__(Config::get('toasts.toasts.update.success')))
             ->autoHide();

        return redirect()->route('platform.courseAssemblies.edit', $courseAssembly);
    }

    public function remove( Request $request ): RedirectResponse {
        CourseAssembly::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')))
             ->autoHide();

        return redirect()->route('platform.courseAssemblies');
    }


    /**
     * @return array
     */
    private function getJsonForCourseAssemblyLevelsField(): array {

        $courseAssemblyLevels = CourseAssemblyLevel::all()->groupBy('digital_value')->get(1)->first();

        return collect($this->courseAssembly->professionalTrajectories)
            ->map(function ( ProfessionalTrajectory $professionalTrajectory ) {
                return [
                    'professional_trajectory' => $professionalTrajectory->id,
                    'course_assembly_level'   => $professionalTrajectory->pivot->course_assembly_level_digital_value,
                ];

            })->toArray();
    }
}
