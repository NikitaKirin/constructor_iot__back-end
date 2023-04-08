<?php

namespace App\Http\Resources\Semester;

use App\Http\Resources\Discipline\DisciplineResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Semester */
class SemesterResource extends JsonResource
{
    public static $wrap = 'semester';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'                       => $this->id,
            'text_representation'      => $this->text_representation,
            'numerical_representation' => $this->numerical_representation,
            'disciplines'       => $this->whenLoaded('disciplines', function () {
                return DisciplineResource::collection($this->disciplines);
            }),
        ];
    }
}
