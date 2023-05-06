<?php

namespace App\Orchid\Screens;

use App\Enums\EntityStatType;
use App\Models\EducationalProgram;
use App\Models\EntityStat;
use App\Orchid\Layouts\AnalyticsCharts\EducationalProgram\LineTopEducationalProgramsInConstructor;
use App\Orchid\Layouts\AnalyticsCharts\EducationalProgram\LineTopEducationalProgramsToMore;
use App\Orchid\Layouts\AnalyticsCharts\EducationalProgram\TotalTopEducationalProgramsInConstructor;
use App\Orchid\Layouts\AnalyticsCharts\EducationalProgram\TotalTopEducationalProgramsToMore;
use Carbon\Carbon;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class AnalyticsScreen extends Screen
{

    public function query(): iterable {
        $lineTopEducationalProgramsInConstructor = EducationalProgram::with('stats')->get()->map(function (EducationalProgram $educationalProgram) {
            return [
                'id'    => $educationalProgram->id,
                'title' => $educationalProgram->title,
                'count' => $educationalProgram->stats()->where('event_type', 'click_in_constructor')
                    ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
                    ->count(),
            ];
        })->sortBy([
            ['count', 'desc'],
        ])->splice(0, 3)->toArray();
        $lineTopEducationalProgramsToMore = EducationalProgram::with('stats')->get()->map(function (EducationalProgram $educationalProgram) {
            return [
                'id'    => $educationalProgram->id,
                'title' => $educationalProgram->title,
                'count' => $educationalProgram->stats()->where('event_type', 'click_to_more')
                    ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
                    ->count(),
            ];
        })->sortBy([
            ['count', 'desc'],
        ])->splice(0, 3)->toArray();
        $start = Carbon::now()->subWeek();
        $end = Carbon::now();
        $educationalProgramTitles = EducationalProgram::orderBy('title')->pluck('title')->toArray();
        return [
            'totalTopEducationalProgramsInConstructor' => [
                [
                    'labels' => $educationalProgramTitles,
                    'name'   => 'Выбирали в конструкторе',
                    'values' => EducationalProgram::orderBy('title')->with('stats')->get()->map(
                        fn(EducationalProgram $educationalProgram) => $educationalProgram->stats()->where('event_type', 'click_in_constructor')->count()
                    )->toArray(),
                ],
            ],
            'lineTopEducationalProgramsInConstructor'  => [
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickInConstructor->value)
                    ->where('entity_id', $lineTopEducationalProgramsInConstructor[0]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsInConstructor[0]['title']),
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickInConstructor->value)
                    ->where('entity_id', $lineTopEducationalProgramsInConstructor[1]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsInConstructor[1]['title']),
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickInConstructor->value)
                    ->where('entity_id', $lineTopEducationalProgramsInConstructor[2]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsInConstructor[2]['title']),
            ],
            'totalTopEducationalProgramsToMore'        => [
                [
                    'labels' => $educationalProgramTitles,
                    'name'   => 'Переходили на страницу обр. программы',
                    'values' => EducationalProgram::orderBy('title')->with('stats')->get()->map(
                        fn(EducationalProgram $educationalProgram) => $educationalProgram->stats()->where('event_type', 'click_to_more')->count()
                    )->toArray(),
                ],
            ],
            'lineTopEducationalProgramsToMore'         => [
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickToMore->value)
                    ->where('entity_id', $lineTopEducationalProgramsToMore[0]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsToMore[0]['title']),
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickToMore->value)
                    ->where('entity_id', $lineTopEducationalProgramsToMore[1]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsToMore[1]['title']),
                EntityStat::where('entity_type', EducationalProgram::class)
                    ->where('event_type', EntityStatType::ClickToMore->value)
                    ->where('entity_id', $lineTopEducationalProgramsToMore[2]['id'])
                    ->countByDays($start, $end)->toChart($lineTopEducationalProgramsToMore[2]['title']),
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return 'Общая статистика';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make('Перейти в раздел детализации')
                ->icon('arrow-right')
                ->type(Color::INFO())
                ->route('platform.detail-analytics'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::columns(
                [
                    TotalTopEducationalProgramsInConstructor::class,
                    LineTopEducationalProgramsInConstructor::class,
                ]
            ),
            Layout::columns(
                [
                    TotalTopEducationalProgramsToMore::class,
                    LineTopEducationalProgramsToMore::class,
                ]
            ),
        ];
    }
}
