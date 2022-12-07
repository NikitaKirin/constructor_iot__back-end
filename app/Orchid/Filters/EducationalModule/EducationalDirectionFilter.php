<?php

namespace App\Orchid\Filters\EducationalModule;

use App\Models\EducationalDirection;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class EducationalDirectionFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Образовательные направления');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'educational_directions',
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run( Builder $builder ): Builder {
        return $builder->whereHas('educationalDirections', function ( Builder $query ) {
            return $query->whereIntegerInRaw('educational_direction_id',
                $this->request->input('educational_directions'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('educational_directions')
                  ->title(__('Образовательные направления'))
                  ->fromModel(EducationalDirection::class, 'title')
                  ->multiple(),
        ];
    }
}
