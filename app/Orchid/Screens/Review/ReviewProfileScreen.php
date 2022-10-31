<?php

namespace App\Orchid\Screens\Review;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReviewProfileScreen extends Screen
{
    public Review $review;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Review $review ): iterable {
        $review->load(['photo']);
        return [
            'review' => $review,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Отзыв: {$this->review?->author}");
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [

            Link::make(__('Edit'))
                ->icon('pencil')
                ->route('platform.reviews.edit', $this->review),

            Button::make(__('Delete'))
                  ->icon('trash')
                  ->type(Color::DANGER())
                  ->method('destroy', ['id' => $this->review->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::legend('review',
                [
                    Sight::make('photo_id', __('Фото'))
                         ->render(function () {
                             $link = $this->review->photo?->url ?? Config::get('constants.avatars.student.url');
                             return "<img src='$link' alt='Фото: {$this->review->author}' width='100'>";
                         }),

                    Sight::make('author', __('Автор отзыва')),

                    Sight::make('text', __('Текст')),

                    Sight::make('educational_direction', __('Дополнительная информация')),

                    Sight::make('year_of_issue', __('Год выпуска'))
                         ->canSee($this->review->year_of_issue ?? false),

                    Sight::make('course', __('Курс обучения'))
                         ->canSee($this->review->course ?? false),
                ])
                  ->title(__('Основная информация')),
        ];
    }

    public function destroy( Request $request ) {
        Review::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__('Отзыв успешно удалён'));

        return redirect()->route('platform.reviews');
    }
}
