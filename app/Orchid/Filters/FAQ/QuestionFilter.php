<?php

namespace App\Orchid\Filters\FAQ;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class QuestionFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Вопрос');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'question',
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder {
        return $builder->where(
            'question',
            'ILIKE',
            '%' . $this->request->input('question') . '%');
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Input::make('question')
                ->title(__('Вопрос'))
                ->type('text')
                ->max(255),
        ];
    }
}
