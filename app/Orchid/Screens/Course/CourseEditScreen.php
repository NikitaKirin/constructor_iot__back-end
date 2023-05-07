<?php

namespace App\Orchid\Screens\Course;

use App\Actions\Course\CreateCourseAction;
use App\Actions\Course\DestroyCourseAction;
use App\Actions\Course\DTO\CreateCourseData;
use App\Actions\Course\DTO\UpdateCourseData;
use App\Actions\Course\UpdateCourseAction;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\Partner;
use App\Orchid\Layouts\Course\CourseEditLayout;
use Illuminate\Http\Request;
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
    public function query(Course $course): iterable {
        $course->load(['partner', 'courseAssemblies', 'realization']);
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
            Layout::block([
                CourseEditLayout::class,
            ])
                ->title(__('Основная информация'))
                ->description(__('Заполните основную информацию о курсе.'))
                ->commands([
                    Button::make(__('Создать'))
                        ->type(Color::SUCCESS())
                        ->method('create')
                        ->canSee(!$this->course->exists),
                    Button::make(__('Обновить'))
                        ->type(Color::SUCCESS())
                        ->method('update')
                        ->canSee($this->course->exists),
                ]),

            Layout::block([
                Layout::rows([
                    Relation::make('courseAssemblies.')
                        ->required()
                        ->title(__('Курсовые сборки'))
                        ->multiple()
                        ->fromModel(CourseAssembly::class, 'title')
                        ->displayAppend('WithEducationalProgram')
                        ->value($this->course->courseAssemblies),

                    Link::make(__('Создать новую'))
                        ->icon('plus')
                        ->route("platform.courseAssemblies.create")
                        ->target('__blank'),
                ]),
            ])
                ->description(__('Добавьте курсовую сборку, к которой относится данный курс. Наличие курсовой сборки необходимо исключительно для абитуриентов.'))
                ->commands([
                    Button::make(__('Создать'))
                        ->type(Color::SUCCESS())
                        ->method('create')
                        ->canSee(!$this->course->exists),
                    Button::make(__('Обновить'))
                        ->type(Color::SUCCESS())
                        ->method('update')
                        ->canSee($this->course->exists),
                ]),

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
                ->commands([
                    Button::make(__('Создать'))
                        ->type(Color::SUCCESS())
                        ->method('create')
                        ->canSee(!$this->course->exists),
                    Button::make(__('Обновить'))
                        ->type(Color::SUCCESS())
                        ->method('update')
                        ->canSee($this->course->exists),
                ]),
        ];
    }

    public function create(CreateCourseRequest $request) {
        $validated = collect($request->validated());
        $course = (new CreateCourseAction())->run(
            new CreateCourseData(
                title: $validated->get('title'),
                description: $validated->get('description'),
                realizationId: $validated->get('realization_id'),
                videoId: $validated->get('video_id', default: [null])[0],
                presentationId: $validated->get('presentation_id', default: [null])[0],
                documentsIds: $validated->get('documents', default: []),
                courseAssemblyIds: $validated->get('courseAssemblies', default: []),
                partnerId: $validated->get('partner_id'),
            )
        );
        Toast::success(__(Config::get('toasts.toasts.create.success')))
            ->autoHide();
        return redirect()->route('platform.courses.edit', $course);
    }

    public function update(Course $course, UpdateCourseRequest $request) {
        $validated = collect($request->validated());
        $status = (new UpdateCourseAction())->run(
            $course,
            new UpdateCourseData(
                title: $validated->get('title'),
                description: $validated->get('description'),
                realizationId: $validated->get('realization_id'),
                videoId: $validated->get('video_id', default: [null])[0],
                presentationId: $validated->get('presentation_id', default: [null])[0],
                documentsIds: $validated->get('documents', default: []),
                disciplineId: $validated->get('discipline_id'),
                courseAssembliesIds: $validated->get('courseAssemblies', default: []),
                partnerId: $validated->get('partner_id'),
            )
        );
        if ($status) {
            Toast::success(__(Config::get('toasts.toasts.update.success')))
                ->autoHide();
        }
        else {
            Toast::error(__(\config('toasts.toasts.update.error')));
        }
    }

    public function destroy(Request $request) {
        $status = (new DestroyCourseAction())->run($request);
        if ($status) {
            Toast::success(config('toasts.toasts.delete.success'));
            return redirect()->route('platform.courses');
        } else
            Toast::error(config('toasts.toasts.delete.error'));
    }
}
