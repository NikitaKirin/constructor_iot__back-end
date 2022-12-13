<?php

namespace App\Orchid\Filters\Review;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class EducationalDirectionFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __("Образовательное направление");
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            "educational_direction",
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
        return $builder->where(
            'educational_direction',
            'ilike',
            "%".$this->request->input('educational_direction')."%"
        );
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make('educational_direction')
                ->type('text')
                ->title(__('Образовательное направление')),
        ];
    }
}
