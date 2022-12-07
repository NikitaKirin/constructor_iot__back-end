<?php

namespace App\Orchid\Filters;

use App\Models\EducationalModule;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class EducationalModuleFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Образовательные модули');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return ['educationalModules'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run( Builder $builder ): Builder {
        //$this->request->dd();
        return $builder->whereHas('educationalModules', function ( Builder $query ) {
            return $query->whereIntegerInRaw('educational_module_id', $this->request->input('educationalModules'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('educationalModules')
                  ->title(__("Образовательные модули"))
                  ->fromModel(EducationalModule::class, 'title')
                  ->empty()
                  ->multiple(),
        ];
    }
}
