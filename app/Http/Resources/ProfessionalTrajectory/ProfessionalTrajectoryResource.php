<?php

namespace App\Http\Resources\ProfessionalTrajectory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/** @mixin \App\Models\ProfessionalTrajectory */
class ProfessionalTrajectoryResource extends JsonResource
{
    public static $wrap = 'professional_trajectory';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'color'       => $this->color,
            'icons'       => $this->when($this->attachment()->exists(), function () {
                return $this->getIconsUrls();
            }),
            //'disciplines' => DisciplineResourceCollection::collection($this->whenLoaded('disciplines')),
        ];
    }

    private function getIconsUrls(): Collection {
        return collect($this->attachment->where('group', 'icons')
                                        ->map(fn( \Orchid\Attachment\Models\Attachment $img ) => $img->url())
        );
    }
}
