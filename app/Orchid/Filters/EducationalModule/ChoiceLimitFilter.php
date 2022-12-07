<?php

namespace App\Orchid\Filters\EducationalModule;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class ChoiceLimitFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Лимит по выбору дисциплин');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'choice_limit',
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
        return $builder->where('choice_limit', $this->request->input('choice_limit'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Input::make('choice_limit')
                 ->type('number')
                 ->title(__("Лимит по выбору дисциплин"))
                 ->popover(__('Сколько дисциплин выбирают студенты в данном модуле')),
        ];
    }
}
