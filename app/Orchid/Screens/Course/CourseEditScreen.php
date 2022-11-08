<?php

namespace App\Orchid\Screens\Course;

use App\Http\Requests\Course\CreateCourseRequest;
use App\Models\Course;
use App\Models\Discipline;
use App\Models\Partner;
use App\Models\Realization;
use App\Orchid\Layouts\Course\CourseEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CourseEditScreen extends Screen
{
    public Course $course;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Course $course ): iterable {
        $course->load(['partner', 'discipline', 'realization']);
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
        return $this->course->exists ? __("Изменить курс: {$this->course->title}") : __("Создать новый курс");
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
                  ->canSee($this->course->exists)
                  ->method('remove', ['id' => $this->course->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block([
                CourseEditLayout::class,
            ])
                  ->title(__('Основная информация'))
                  ->description(__('Заполните основную информацию о курсе.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

            Layout::block([
                Layout::rows([
                    Relation::make('discipline_id')
                            ->title(__('Дисциплина'))
                            ->fromModel(Discipline::class, 'title')
                            ->value($this->course->discipline),

                    Link::make(__('Создать новую'))
                        ->icon('plus')
                        ->route("platform.disciplines.create")
                        ->target('__blank'),
                ]),
            ])
                  ->description(__('Добавьте дисциплину, к которой относится данный курс. Наличие дисциплины необходимо исключительно для абитуриентов.'))
                  ->commands(Button::make(__('Save'))
                                   ->type(Color::SUCCESS())
                                   ->method('save')),

            Layout::block([
                Layout::rows([
                    Relation::make('partner_id')
                            ->title(__('Партнер'))
                            ->fromModel(Partner::class, 'title')
                            ->value($this->course->partner),

                    Link::make(__('Создать нового'))
                        ->icon('plus')
                        ->route("platform.partners.create")
                        ->target('__blank'),
                ]),
            ])
                  ->description(__('Добавьте партнера, который является создателем курса.'))
                  ->commands(Button::make(__('Save'))
                                   ->type(Color::SUCCESS())
                                   ->method('save'))
            ,
        ];
    }

    public function save( Course $course, CreateCourseRequest $request ) {

        $course->fill($request->validated())
               ->user()->associate(Auth::user());

        if ( $discipline_id = $request->input('discipline_id') ) {
            $course->discipline()
                   ->associate(Discipline::findOrFail($discipline_id));
        }

        if ( $partnerId = $request->input('partner_id') ) {
            $course->partner()->associate(Partner::findOrFail($partnerId));
        }

        $course->realization()->associate(Realization::findOrFail($request->input('realization_id')));

        $course->save();

        Toast::success(__(Config::get('toasts.toasts.update.success')))
             ->autoHide();

        //return redirect()->route('platform.courses.edit');
    }

    public function destroy( Request $request ) {
        Course::findOrFail($request->input('id'))->forceDelete();
    }
}
