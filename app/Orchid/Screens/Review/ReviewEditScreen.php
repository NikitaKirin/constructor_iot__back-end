<?php

namespace App\Orchid\Screens\Review;

use App\Http\Requests\Review\CreateReviewRequest;
use App\Models\Review;
use App\Orchid\Layouts\Review\ReviewEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReviewEditScreen extends Screen
{
    public Review $review;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Review $review ): iterable {
        $review->load(['photo', 'user']);

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
        return $this->review->exists() ? "Изменить отзыв: {$this->review->author}" : __('Создать отзыв');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [

            Layout::block(ReviewEditLayout::class)
                  ->title('Основная информация')
                  ->commands([

                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),

                      Button::make(__('Delete'))
                            ->canSee($this->review->exists())
                            ->type(Color::DANGER())
                            ->method('destroy', ['id' => $this->review->id]),
                  ]),


        ];
    }

    public function save( Review $review, CreateReviewRequest $request ) {

        $fields = array_merge(
            $request->validated(),
            [
                "hidden" => $request->boolean('hidden'),
            ]
        );

        $review->fill($fields)
               ->user()
               ->associate(Auth::user())
               ->save();

        if ( $request->input('photo_id') ) {

            $review->attachment()->syncWithoutDetaching(
                $request->input('photo_id', []),
            );
            $review->photo_id = $review->attachment()->first()?->id;
            $review->save();
        }
        else {
            $review->photo->delete();
        }

        Toast::success('Отзыв успешно обновлен');

        return redirect()->route('platform.reviews.profile', ['review' => $review]);

    }

    public function destroy( Request $request ) {
        Review::findOrFail($request->get('id'))->forceDelete();

        Toast::success(__('Отзыв успешно удален'));

        return redirect()->route('platform.reviews');
    }
}
