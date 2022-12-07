<?php

namespace App\Orchid\Screens\Partner;

use App\Models\Partner;
use App\Orchid\Layouts\Parnter\PartnerFilters;
use App\Orchid\Layouts\Partner\PartnerListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PartnerListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            "partners" => Partner::filters(PartnerFilters::class)
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
        return 'Список партнёров';
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
                ->route('platform.partners.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            PartnerFilters::class,
            PartnerListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        Partner::findOrFail($request->get('id'))->forceDelete();

        Toast::success(__('Партнер успешно удален'));

        return redirect()->back();
    }
}
