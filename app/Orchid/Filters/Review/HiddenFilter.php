<?php

namespace App\Orchid\Filters\Review;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Switcher;

class HiddenFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Скрыто');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            "hidden",
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('hidden', 'like', $this->request->boolean('hidden'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Switcher::make('hidden')
            ->title(__("Скрыто"))
            ->popover(__("Отображается отзыв на странице или нет")),
        ];
    }
}
