<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Partner\PartnerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Course */
class CourseResource extends JsonResource
{
    public static $wrap = 'course';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'limit'       => $this->limit,

            //'discipline_id' => $this->discipline_id,
            'realization' => $this->realization->title,

            //            'discipline' => new DisciplineResource($this->whenLoaded('discipline')),
            'partner'     => $this->when($this->partner()->exists(), function () {
                return new PartnerResource($this->partner);
            }),
        ];
    }
}
