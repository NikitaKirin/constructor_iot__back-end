<?php

namespace App\Orchid\Screens\EducationalModule;

use App\Models\EducationalModule;
use App\Orchid\Layouts\EducationalModule\EducationalModuleFilters;
use App\Orchid\Layouts\EducationalModule\EducationalModuleListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class EducationalModuleListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'educationalModules' => EducationalModule::filters(EducationalModuleFilters::class)
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
        return __('Список образовательных модулей');
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
                ->route('platform.educationalModules.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            EducationalModuleFilters::class,
            EducationalModuleListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        EducationalModule::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')))
             ->autoHide();
    }
}
