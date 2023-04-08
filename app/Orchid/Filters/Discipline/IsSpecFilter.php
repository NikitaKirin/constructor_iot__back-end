<?php

namespace App\Orchid\Filters\Discipline;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Switcher;

class IsSpecFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __("Спец-дисциплина");
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'is_spec',
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
        return $builder->where('is_spec', $this->request->boolean('is_spec', false));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Switcher::make('is_spec')
                    ->title(__('Спец-дисциплина'))
                    ->popover(__('Спец-дисциплина - дисциплина, которая имеет более одной курсовой сборки. В этот перечень не входит блок с обязательными курсами.'))
                    ->placeholder('Является спец-дисциплиной')
                    ->sendTrueOrFalse(),
        ];
    }
}
