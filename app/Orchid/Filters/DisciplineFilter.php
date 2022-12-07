<?php

namespace App\Orchid\Filters;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class DisciplineFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Дисциплины');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'disciplines',
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
        return $builder->whereHas('discipline', function ( Builder $query ) {
            return $query->whereIn('discipline_id', $this->request->input('disciplines'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('disciplines')
                  ->title(__('Дисциплины'))
                  ->fromModel(Discipline::class, 'title')
                  ->multiple(),
        ];
    }
}
