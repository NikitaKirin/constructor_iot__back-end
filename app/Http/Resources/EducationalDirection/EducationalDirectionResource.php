<?php

namespace App\Http\Resources\EducationalDirection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\EducationalDirection */
class EducationalDirectionResource extends JsonResource
{
    public static $wrap = 'educational_direction';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'cipher'          => $this->cipher,
            'passing_scores'  => $this->passing_scores,
            'training_period' => $this->training_period,
            'budget_places'   => $this->budget_places,
        ];
    }
}
