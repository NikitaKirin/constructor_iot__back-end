<?php

namespace App\Http\Resources\ProfessionalTrajectory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Orchid\Attachment\Models\Attachment;

/** @mixin \App\Models\ProfessionalTrajectory */
class ProfessionalTrajectoryResource extends JsonResource
{
    public static $wrap = 'professional_trajectory';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'color' => $this->color,
            'sum_discipline_levels_points' => $this->sum_discipline_levels_points,
            'icons' => $this->getIconsUrls(),
            'discipline_evaluation' => $this->whenPivotLoaded('discipline_professional_trajectory', function () {
                return $this->pivot->discipline_level_digital_value;
            }),
            'disciplines_count' => $this->whenCounted('disciplines'),
            'vacancies_count' => 100,
            //'disciplines' => DisciplineResourceCollection::collection($this->whenLoaded('disciplines')),
        ];
    }

    private function getIconsUrls(): Collection
    {
        return collect(
            $this->attachment->where('group', 'icons')
                ->map(fn(Attachment $img) => $img->url())
        );
    }
}
