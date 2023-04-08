<?php

namespace App\Orchid\Filters;

use App\Models\CourseAssembly;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class CourseAssemblyFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Курсовые сборки');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'courseAssemblies',
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
        return $builder->whereHas('courseAssembly', function ( Builder $query ) {
            return $query->whereIn('course_assembly_id', $this->request->input('courseAssemblies'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('courseAssemblies')
                  ->title(__('Курсовые сборки'))
                  ->fromModel(CourseAssembly::class, 'title')
                  ->multiple(),
        ];
    }
}
