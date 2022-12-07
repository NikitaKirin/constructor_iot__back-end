<?php

namespace App\Orchid\Filters\Discipline;

use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ProfessionalTrajectoryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string {
        return __('Профессиональные траектории');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array {
        return [
            "professional_trajectories",
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
        return $builder->whereHas('professionalTrajectories', function ( Builder $query ) {
            return $query->whereIntegerInRaw('professional_trajectory_id',
                $this->request->input('professional_trajectories'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable {
        return [
            Select::make('professional_trajectories')
                  ->title(__('Профессиональные траектории'))
                  ->fromModel(ProfessionalTrajectory::class, 'title')
                  ->multiple(),
        ];
    }
}
