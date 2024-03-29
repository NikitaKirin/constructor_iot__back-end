<?php

namespace App\Orchid\Screens\ProfessionalTrajectory;

use App\Http\Requests\ProfessionalTrajectory\CreateProfessionalTrajectoryRequest;
use App\Models\CourseAssembly;
use App\Models\ProfessionalTrajectory;
use App\Orchid\Layouts\ProfessionalTrajectory\ProfessionalTrajectoryEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProfessionalTrajectoryEditScreen extends Screen
{
    public ProfessionalTrajectory $professionalTrajectory;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( ProfessionalTrajectory $professionalTrajectory ): iterable {
        $professionalTrajectory->load(['courseAssemblies']);
        return [
            'professionalTrajectory' => $professionalTrajectory,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->professionalTrajectory->exists
            ? __("Профессиональная траектория: {$this->professionalTrajectory->title}")
            : __('Создать новую траекторию');
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
                  ->method('destroy', ['id' => $this->professionalTrajectory->id]),

        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [

            Layout::block(ProfessionalTrajectoryEditLayout::class)
                  ->title(__('Основная информация'))
                  ->description(__('Заполните основную информацию о траектории')),

            Layout::block([
                Layout::rows([

                    Relation::make('courseAssemblies.')
                            ->fromModel(CourseAssembly::class, 'title')
                            ->multiple()
                            ->displayAppend('WithEducationalProgram')
                            ->value($this->professionalTrajectory->courseAssemblies)
                            ->title(__('Список курсовых сборок')),

                ]),
            ])
                  ->title(__('Курсовые сборки'))
                  ->description(__('Выберете курсовые сборки, которые определяют текущий профессиональный трек.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Link::make(__('Создать новую курсовую сборку'))
                          ->icon('plus')
                          ->route('platform.courseAssemblies.create')
                          ->target('_blank'),
                  ]),

        ];
    }

    public function save( ProfessionalTrajectory $professionalTrajectory, CreateProfessionalTrajectoryRequest $request ) {

        $professionalTrajectory->fill($request->validated())
                               ->user()->associate(Auth::user())
                               ->save();

        $professionalTrajectory->courseAssemblies()->syncWithPivotValues(
            $request->input('courseAssemblies', []),
            ['course_assembly_level_digital_value' => 1]); //todo: pivot

        $professionalTrajectory->attachment()->sync(
            $request->input('icons', [])
        );

        Toast::success(config('toasts.toasts.update.success'));
    }

    public function destroy( Request $request ) {

        ProfessionalTrajectory::findOrFail($request->input('id'))
                              ->forceDelete();

        Toast::success(config('toasts.toasts.delete.success'));
    }
}
