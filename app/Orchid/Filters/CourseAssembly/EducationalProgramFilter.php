<?php

namespace App\Orchid\Filters\CourseAssembly;

use App\Models\EducationalProgram;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class EducationalProgramFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Образовательные программы');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            'educational_programs',
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
        return $builder->whereHas('discipline.educationalProgram', function (Builder $builder){
            return $builder->whereIntegerInRaw('id', $this->request->input('educational_programs'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('educational_programs')
                ->title(__('Образовательные программы'))
                ->fromModel(EducationalProgram::class, 'title')
                ->multiple(),
        ];
    }
}
