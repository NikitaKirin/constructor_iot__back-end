<?php

namespace App\Orchid\Screens;

use App\Enums\EntityStatType;
use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Partner;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use App\Orchid\Layouts\DetailAnalyticsChart\Course\CoursesPercentageChart;
use App\Orchid\Layouts\DetailAnalyticsChart\Course\PartnerCoursesClickToMore;
use App\Orchid\Layouts\DetailAnalyticsChart\Course\PartnerCoursesProportionsChart;
use App\Orchid\Layouts\DetailAnalyticsChart\CourseAssembly\CourseAssemblyClickInConstructorChart;
use App\Orchid\Layouts\DetailAnalyticsChart\CourseAssembly\CourseAssemblyClickToMoreChart;
use App\Orchid\Layouts\DetailAnalyticsChart\FiltersLayout;
use App\Orchid\Layouts\DetailAnalyticsChart\Profession\ProfessionClickToMoreChart;
use App\Orchid\Layouts\DetailAnalyticsChart\Profession\ProfessionMedianSalaryBarChart;
use App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory\ProfessionalTrajectoryClickInConstructorChart;
use App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory\ProfessionalTrajectoryClickInListChart;
use App\Orchid\Layouts\DetailAnalyticsChart\ProfessionalTrajectory\ProfessionalTrajectoryProportionsChart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class DetailAnalyticsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Request $request = null): iterable {
        $educationalProgramId = $request->get('educational_program_id') ?? EducationalProgram::first()->id;
        $period = $request->get('period');
        return [
            'educationalProgramId'                       => $educationalProgramId,
            'period'                                     => $period,
            'courseAssembliesClickInConstructor'         => $this->getCourseAssembliesChartData($educationalProgramId, EntityStatType::ClickInConstructor->value, $period),
            'courseAssembliesClickToMore'                => $this->getCourseAssembliesChartData($educationalProgramId, EntityStatType::ClickToMore->value, $period),
            'professionalTrajectoriesClickInConstructor' => $this->getProfessionalTrajectoriesChartData($educationalProgramId, EntityStatType::ClickInConstructor->value, $period),
            'professionalTrajectoriesClickInList'        => $this->getProfessionalTrajectoriesChartData($educationalProgramId, EntityStatType::ClickInList->value, $period),
            'professionalTrajectoriesProportions'        => $this->getProfessionalTrajectoriesProportionsChartData($educationalProgramId),
            'partnerCoursesProportions'                  => $this->getPartnerCoursesProportionsChartData($educationalProgramId),
            'coursesPercentage'                          => $this->getCoursesPercentageChartData($educationalProgramId),
            'professionMedianSalaries'                   => $this->getProfessionMedianSalariesChartData($educationalProgramId),
            'professionsClickToMore'                     => $this->getProfessionsChartData($educationalProgramId, EntityStatType::ClickToMore->value, $period),
            'partnerCoursesClickToMore'                  => $this->getPartnerCoursesChartData($educationalProgramId, EntityStatType::ClickToMore->value, $period),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return 'Подробная статистика';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block([
                FiltersLayout::class,
            ])->commands([
                Button::make('Применить')
                    ->type(Color::SUCCESS())
                    ->method('storeFilter'),
                Button::make('Очистить фильтры')
                    ->type(Color::DEFAULT())
                    ->method('resetFilter'),
            ])
                ->title('Фильтрация'),
            Layout::tabs([
                'Курсы'                       => [
                    CoursesPercentageChart::class,
                    PartnerCoursesProportionsChart::class,
                    PartnerCoursesClickToMore::class,
                ],
                'Курсовые сборки'             => [
                    CourseAssemblyClickInConstructorChart::class,
                    CourseAssemblyClickToMoreChart::class,
                ],
                'Профессиональные траектории' => [
                    ProfessionalTrajectoryClickInConstructorChart::class,
                    ProfessionalTrajectoryClickInListChart::class,
                    ProfessionalTrajectoryProportionsChart::class,
                ],
                'Профессии'                   => [
                    ProfessionMedianSalaryBarChart::class,
                    ProfessionClickToMoreChart::class,
                ],
            ]),
        ];
    }

    public function storeFilter(Request $request): RedirectResponse {
        return redirect()->to(route('platform.detail-analytics',
            [
                'educational_program_id' => $request->get('educational_program_id'),
                'period'                 => $request->get('period'),
            ]));
    }

    public function resetFilter(): RedirectResponse {
        return redirect()->to(route('platform.detail-analytics'));
    }

    private function getCourseAssembliesChartData(int $educationalProgramId, string $eventType, ?array $period): array {
        $courseAssemblies = CourseAssembly::whereHas('discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        );
        $name = ($eventType === EntityStatType::ClickInConstructor->value) ? __('Выбирали в конструкторе') : __('Количество кликов по кнопке "подробнее"');
        $courseAssemblies = $this->getEntityRecordsWithStats($courseAssemblies, $eventType, $period);
        return [
            [
                'labels' => $courseAssemblies->pluck('title')->toArray(),
                'name'   => $name,
                'values' => $courseAssemblies->pluck('stats_count')->toArray(),
            ],
        ];
    }

    private function getProfessionalTrajectoriesChartData(int $educationalProgramId, string $eventType, ?array $period): array {
        $professionalTrajectories = ProfessionalTrajectory::whereHas('courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        );
        $name = ($eventType === EntityStatType::ClickInConstructor->value) ? __('Выбирали в конструкторе') : __('Выбирали из списка готовых');
        $professionalTrajectories = $this->getEntityRecordsWithStats($professionalTrajectories, $eventType, $period);
        return [
            [
                'labels' => $professionalTrajectories->pluck('title')->toArray(),
                'name'   => $name,
                'values' => $professionalTrajectories->pluck('stats_count')->toArray(),
            ],
        ];
    }

    private function getPartnerCoursesChartData(int $educationalProgramId, string $value, ?array $period): array {
        $partnerCourses = Course::whereHas('courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->has('partner');
        $partnerCourses = $this->getEntityRecordsWithStats($partnerCourses, EntityStatType::ClickToMore->value, $period);
        return [
            [
                'labels' => $partnerCourses->pluck('title')->toArray(),
                'name'   => 'Количество кликов по курсу',
                'values' => $partnerCourses->pluck('stats_count')->toArray(),
            ],
        ];
    }

    private function getProfessionsChartData(int $educationalProgramId, string $eventType, ?array $period) {
        $professions = Profession::whereHas('professionalTrajectories.courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId),
        );
        $professions = $this->getEntityRecordsWithStats($professions, $eventType, $period);
        return [
            [
                'labels' => $professions->pluck('title')->toArray(),
                'name'   => 'Количество кликов по профессии',
                'values' => $professions->pluck('stats_count')->toArray(),
            ],
        ];
    }

    private function getEntityRecordsWithStats(Builder $builder, $eventType, ?array $period): Collection {
        if ($period) {
            return $builder->whereHas('stats',
                fn(Builder $builder) => $builder->where('event_type', $eventType)
                    ->whereBetween('created_at', [$period['start'], $period['end']])
            )->withCount([
                'stats' => fn(Builder $builder) => $builder->where('event_type', $eventType)
                    ->whereBetween('created_at', [$period['start'], $period['end']]),
            ])
                ->orderBy('stats_count', 'desc')
                ->limit(5)
                ->get();
        } else {
            return $builder->whereHas('stats', fn(Builder $builder) => $builder->where('event_type', $eventType))
                ->withCount(['stats' => fn(Builder $builder) => $builder->where('event_type', $eventType)])
                ->orderBy('stats_count', 'desc')
                ->limit(5)
                ->get();
        }
    }

    private function getProfessionalTrajectoriesProportionsChartData(int $educationalProgramId): array {
        $professionalTrajectories = ProfessionalTrajectory::whereHas('courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->withCount([
            'courseAssemblies' => function (Builder $builder) use ($educationalProgramId) {
                return $builder->whereHas('discipline.educationalPrograms', fn(Builder $builder) => $builder->where('id', $educationalProgramId));
            },
        ])->get();
        return [
            [
                "labels" => $professionalTrajectories->pluck('title')->toArray(),
                'name'   => 'Количество курсовых сборок',
                'values' => $professionalTrajectories->pluck('course_assemblies_count')->toArray(),
            ],
        ];
    }

    private function getPartnerCoursesProportionsChartData(int $educationalProgramId) {
        $partners = Partner::whereHas('courses.courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->withCount([
            'courses' => function (Builder $builder) use ($educationalProgramId) {
                return $builder->whereHas('courseAssemblies.discipline.educationalPrograms', fn(Builder $builder) => $builder->where('id', $educationalProgramId));
            },
        ])->get();

        return [
            [
                'labels' => $partners->pluck('title')->toArray(),
                'name'   => 'Количество курсов',
                'values' => $partners->pluck('courses_count')->toArray(),
            ],
        ];
    }

    private function getCoursesPercentageChartData(int $educationalProgramId): array {
        $univerCoursesCount = Course::whereHas('courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->doesntHave('partner')->get()->count();
        $partnerCoursesCount = Course::whereHas('courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->has('partner')->get()->count();
        return [
            [
                'labels' => ['Университетские курсы', 'Партнерские курсы'],
                'values' => [$univerCoursesCount, $partnerCoursesCount],
            ],
        ];
    }

    private function getProfessionMedianSalariesChartData(int $educationalProgramId): array {
        $professions = Profession::whereHas('professionalTrajectories.courseAssemblies.discipline.educationalPrograms',
            fn(Builder $builder) => $builder->where('id', $educationalProgramId)
        )->where('median_salary', '>', 0)
            ->orderBy('median_salary', 'desc')
            ->get();

        return [
            [
                'labels' => $professions->pluck('title'),
                'name'   => 'Медианная зарплата',
                'values' => $professions->pluck('median_salary'),
            ],
        ];
    }

}
