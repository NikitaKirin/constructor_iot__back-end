<?php

namespace App\Orchid\Screens\Discipline;

use App\Http\Requests\Discipline\CreateDisciplineRequest;
use App\Models\Course;
use App\Models\Discipline;
use App\Models\DisciplineLevel;
use App\Models\EducationalModule;
use App\Models\ProfessionalTrajectory;
use App\Orchid\Layouts\Discipline\DisciplineEditLayout;
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

class DisciplineEditScreen extends Screen
{
    public Discipline $discipline;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Discipline $discipline ): iterable {
        $discipline->load(['educationalModules', 'courses', 'professionalTrajectories']);
        return [
            'discipline' => $discipline,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->discipline->exists ? __("Обновить дисциплину: {$this->discipline->title}") : __("Создать новую дисциплину");
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
                  ->canSee($this->discipline->exists)
                  ->method('remove', ['id' => $this->discipline->id]),
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
            Layout::block(DisciplineEditLayout::class)
                  ->title(__('Основная информация'))
                  ->description(__('Обновите информацию о дисциплине, заполнив соответсвующее поля.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

            Layout::block([
                Layout::rows([
                    Relation::make('educationalModules.')
                            ->fromModel(EducationalModule::class, 'title')
                            ->multiple()
                            ->value($this->discipline->educationalModules)
                            ->title(__('Список образовательных модулей')),
                ]),
            ])
                  ->title(__('Образовательные модули'))
                  ->description(__('Выберите образовательные модули, которым принадлежит данная дисциплина, из предложенного списка'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Link::make(__('Создать новый модуль'))
                          ->icon('plus')
                          ->target('_blank')
                          ->route('platform.educationalModules.create'),
                  ]),


            Layout::block([
                Layout::rows([
                    Relation::make('courses.')
                            ->fromModel(Course::class, 'title')
                            ->multiple()
                            ->value($this->discipline->courses)
                            ->title(__('Список курсов')),
                ]),
            ])
                  ->title(__('Курсы'))
                  ->description(__('Выберите курсы, которые принадлежат данной дисциплине, из предложенного списка'))
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
                              'Оценка курса для траектории' => 'discipline_level',
                          ])
                          ->fields([
                              'professional_trajectory' => Select::make('professional_trajectory')
                                                                 ->fromModel(ProfessionalTrajectory::class, 'title'),
                              'discipline_level'        => Select::make('discipline_level')
                                                                 ->fromModel(DisciplineLevel::class, 'title',
                                                                     'digital_value'),
                          ])
                        //->canSee($this->discipline->professionalTrajectories()->exists())
                          ->value($this->getJsonForCourseLevelsField()),
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

        /* Layout::block([
             Layout::rows([
                 Relation::make('professionalTrajectories.')
                         ->fromModel(ProfessionalTrajectory::class, 'title')
                     //->chunk(30)
                         ->multiple()
                         ->value($this->discipline->professionalTrajectories)
                         ->title(__('Список профессиональных траекторий')),
             ]),
         ])
               ->title(__('Профессиональные траектории'))
               ->description(__('Выберите траектории, которые принадлежат данной дисциплине, из предложенного списка'))
               ->commands([
                   Button::make(__('Save'))
                         ->type(Color::SUCCESS())
                         ->method('save'),
                   Link::make(__('Создать новую траекторию'))
                       ->icon('plus')
                       ->route('platform.professionalTrajectories.create')
                       ->target('_blank'),
               ]),

         Layout::block([
             Layout::rows([
                 Matrix::make('course_levels')
                       ->title(__('Оценивание'))
                       ->columns([
                           'Профессиональная траектория' => 'professional_trajectory',
                           'Значение курса'              => 'course_level_id',
                       ])
                       ->fields([
                           'professional_trajectory' => Input::make()
                                                             ->type('text')
                                                             ->disabled(),
                           'course_level_id'         => Select::make('course_level')
                                                              ->fromModel(DisciplineLevel::class, 'title', 'id'),
                       ])
                       ->canSee($this->discipline->professionalTrajectories()->exists())
                       ->value($this->getJsonForCourseLevelsField()),
             ]),
         ])
               ->title(__('Оценивание')),
     ];*/
    }

    public function save( Discipline $discipline, CreateDisciplineRequest $request ) {

        //dd($request->input('trajectories_levels'));

        $trajectories = collect($request->input('trajectories_levels', []))
            ->unique('professional_trajectory')
            ->keyBy('professional_trajectory')
            ->map(fn( $item ) => ['discipline_level_digital_value' => $item['discipline_level']]);

        $discipline->fill($request->validated())
                   ->user()->associate(Auth::user())
                   ->save();

        $discipline->educationalModules()
                   ->sync($request->input('educationalModules', []));

        $discipline->professionalTrajectories()
                   ->sync($trajectories);

        if ( $courses_ids = $request->input('courses') ) {
            $courses = Course::findMany($courses_ids);
            $discipline->courses()->saveMany($courses);
        }

        $sums = ProfessionalTrajectory::countSumDisciplineLevelsPoints();

        $sums->each(function ( $item, $key ) {
            ProfessionalTrajectory::find($key)->update(['sum_discipline_levels_points' => $item]);
        });

        Toast::success(__(Config::get('toasts.toasts.update.success')))
             ->autoHide();

        return redirect()->route('platform.disciplines.edit', $discipline);
    }

    public function remove( Request $request ): RedirectResponse {
        Discipline::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')))
             ->autoHide();

        return redirect()->route('platform.disciplines');
    }


    /**
     * @return array
     */
    private function getJsonForCourseLevelsField(): array {

        $disciplineLevels = DisciplineLevel::all()->groupBy('digital_value')->get(1)->first();

        return collect($this->discipline->professionalTrajectories)
            ->map(function ( ProfessionalTrajectory $professionalTrajectory ) {
                return [
                    'professional_trajectory' => $professionalTrajectory->id,
                    'discipline_level'        => $professionalTrajectory->pivot->discipline_level_digital_value,
                ];

            })->toArray();
    }
}
