<?php

namespace App\Http\Resources;

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
            /*            'created_at'                => $this->created_at,
                        'updated_at'                => $this->updated_at,
                        'educational_modules_count' => $this->educational_modules_count,

                        'user_id' => $this->user_id,

                        'educationalModules' => EducationalModuleResourceCollection::collection($this->whenLoaded('educationalModules')),*/
        ];
    }
}
