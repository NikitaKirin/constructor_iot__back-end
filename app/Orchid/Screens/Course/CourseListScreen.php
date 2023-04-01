<?php

namespace App\Orchid\Screens\Course;

use App\Actions\Course\DestroyCourseAction;
use App\Models\Course;
use App\Orchid\Layouts\Course\CourseFilters;
use App\Orchid\Layouts\Course\CourseListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CourseListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'courses' => Course::filters(CourseFilters::class)
                               ->defaultSort('id')
                               ->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Список курсов');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.courses.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            CourseFilters::class,
            CourseListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        $status = (new DestroyCourseAction())->run($request);
        if ($status) {
            Toast::success(config('toasts.toasts.delete.success'));
            return redirect()->route('platform.courses');
        } else
            Toast::error(config('toasts.toasts.delete.error'));
    }
}
