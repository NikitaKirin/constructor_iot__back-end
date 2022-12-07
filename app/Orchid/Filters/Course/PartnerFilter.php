<?php

namespace App\Orchid\Filters\Course;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class PartnerFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Партнеры');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'partners',
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
        return $builder->whereIn('partner_id', $this->request->input('partners'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('partners')
                  ->title(__('Партнеры'))
                  ->fromModel(Partner::class, 'title')
                  ->multiple(),
        ];
    }
}
