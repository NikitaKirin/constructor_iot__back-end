<?php

namespace App\Orchid\Screens\CourseAssemblies;

use App\Models\CourseAssembly;
use App\Orchid\Layouts\CourseAssembly\CourseAssemblyFilters;
use App\Orchid\Layouts\CourseAssembly\CourseAssemblyListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CourseAssemblyListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'courseAssemblies' => CourseAssembly::filters(CourseAssemblyFilters::class)
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
        return __('Список курсовых сборок');
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
                ->route('platform.courseAssemblies.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            CourseAssemblyFilters::class,
            CourseAssemblyListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        CourseAssembly::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')))
             ->autoHide();
    }
}
