<?php

namespace App\Orchid\Screens\Discipline;

use App\Http\Requests\Discipline\CreateDisciplineRequest;
use App\Models\CourseAssembly;
use App\Models\Discipline;
use App\Models\EducationalProgram;
use App\Orchid\Layouts\Discipline\DisciplineEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
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
    public function query(Discipline $discipline ): iterable {
        $discipline->load(['educationalPrograms']);
        return [
            "discipline" => $discipline,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->discipline->exists ? __("Изменить дисциплину: {$this->discipline->title}") : __('Создать новую дисциплину');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block(DisciplineEditLayout::class)
                  ->title(__('Основная информация'))
                  ->description(__('Обновите информацию об образовательной дисциплине, заполнив соответсвующее поля.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Button::make(__('Delete'))
                            ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                            ->type(Color::DANGER())
                            ->canSee($this->discipline->exists)
                            ->method('remove', ['id' => $this->discipline->id]),
                  ]),
        ];
    }

    public function save(Discipline $discipline, CreateDisciplineRequest $request ) {


        $discipline->fill($request->validated())
                          ->user()->associate(Auth::user());

        $discipline->educationalPrograms()->sync($request->get('educationalPrograms', []));

        $discipline->save();

        $discipline->semesters()
                          ->sync($request->get('semesters', []));


        Toast::success(__(\config('toasts.toasts.update.success')))
             ->autoHide();

        return redirect()->route('platform.disciplines.edit', ['discipline' => $discipline]);
    }

    public function remove( Request $request ) {
        Discipline::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(\config('toasts.toasts.delete.success')))
             ->autoHide();

        return redirect()->route('platform.disciplines');
    }
}
