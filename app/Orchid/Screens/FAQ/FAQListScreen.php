<?php

namespace App\Orchid\Screens\FAQ;

use App\Actions\FAQ\DestroyFAQAction;
use App\Models\FAQ;
use App\Orchid\Layouts\Employee\EmployeeFilters;
use App\Orchid\Layouts\FAQ\FAQFilters;
use App\Orchid\Layouts\FAQ\FAQListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class FAQListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'faq' => FAQ::filters(FAQFilters::class)->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Список часто задаваемых вопросов');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.faq.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            FAQFilters::class,
            FAQListLayout::class,
        ];
    }

    public function remove(Request $request) {

        $status = (new DestroyFAQAction())->run($request);

        if ($status) {
            Toast::success(config('toasts.toasts.delete.success'));
        } else
            Toast::error(config('toasts.toasts.delete.error'));
    }
}
