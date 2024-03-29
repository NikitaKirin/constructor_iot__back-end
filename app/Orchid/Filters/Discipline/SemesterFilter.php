<?php

namespace App\Orchid\Filters\Discipline;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class SemesterFilter extends Filter
{
    public function name(): string {
        return __("Семестры");
    }

    public function parameters(): ?array {
        return [
            'semesters',
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
        return $builder->whereHas('semesters', function ( Builder $query ) {
            return $query->whereIntegerInRaw('semester_id', $this->request->input('semesters'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('semesters')
                ->fromModel(Semester::class, 'text_representation')
                ->empty()
                ->multiple()
                ->title(__('Семестры')),
        ];
    }
}
