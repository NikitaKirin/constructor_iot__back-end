<?php

namespace App\Http\Resources\CourseAssemblyLevel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\CourseAssemblyLevel */
class CourseAssemblyLevelResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'digital_value' => $this->digital_value,
        ];
    }
}
