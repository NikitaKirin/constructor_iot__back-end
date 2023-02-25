<?php

namespace App\Orchid\Screens\Profession;

use App\Models\Profession;
use App\Orchid\Layouts\Profession\ProfessionFilters;
use App\Orchid\Layouts\Profession\ProfessionListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProfessionListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'professions' => Profession::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Список профессий');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.professions.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProfessionFilters::class,
            ProfessionListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        Profession::findOrFail($request->get('id'))->forceDelete();

        Toast::success(config('toasts.toasts.delete.success'));
    }
}
