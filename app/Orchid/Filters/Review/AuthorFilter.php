<?php

namespace App\Orchid\Filters\Review;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class AuthorFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __("Имя автора");
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            "author",
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
        return $builder->where('author', 'ilike', "%".$this->request->input('author')."%");
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make('author')
                ->title(__('Имя автора'))
                ->type('text'),
        ];
    }
}
