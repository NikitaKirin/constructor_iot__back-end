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
        ];
    }

    public function save( Course $course, CreateCourseRequest $request ) {

        $course->fill($request->validated())
               ->user()->associate(Auth::user());

        $course->discipline()
               ->associate(Discipline::findOrFail($request->input('discipline_id')));

        if ( $partnerId = $request->input('partner_id') ) {
            $course->partner()->associate(Partner::findOrFail($partnerId));
        }

        $course->realization()->associate(Realization::findOrFail($request->input('realization_id')));

        $course->save();

        Toast::success(__(Config::get('toasts.toasts.update.success')))
             ->autoHide();

        return redirect()->route('platform.courses');
    }

    public function destroy( Request $request ) {
        Course::findOrFail($request->input('id'))->forceDelete();
    }
}
