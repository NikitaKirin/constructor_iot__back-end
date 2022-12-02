<?php

namespace App\Orchid\Screens\Review;

use App\Models\Review;
use App\Orchid\Layouts\Review\ReviewListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ReviewListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'reviews' => Review::filters()
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
        return __('Список отзывов');
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
                ->route('platform.reviews.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            ReviewListLayout::class,
        ];
    }

    public function destroy( Request $request ) {
        Review::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__('Отзыв успешно удален'))
             ->autoHide();

        return redirect()->back();
    }
}
