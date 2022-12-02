<?php

namespace App\Orchid\Screens\ProfessionalTrajectory;

use App\Models\ProfessionalTrajectory;
use App\Orchid\Layouts\ProfessionalTrajectory\ProfessionalTrajectoryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProfessionalTrajectoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'professionalTrajectories' => ProfessionalTrajectory::filters()
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
        return __('Список профессиональных траекторий');
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
                ->route('platform.professionalTrajectories.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            ProfessionalTrajectoryListLayout::class,
        ];
    }

    public function destroy( Request $request ) {

        ProfessionalTrajectory::findOrFail($request->input('id'))
                              ->forceDelete();

        Toast::success(config('toasts.toasts.delete.success'));
    }
}
