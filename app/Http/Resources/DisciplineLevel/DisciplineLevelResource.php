<?php

namespace App\Http\Resources\DisciplineLevel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\DisciplineLevel */
class DisciplineLevelResource extends JsonResource
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
            /*            'created_at'    => $this->created_at,
                        'updated_at'    => $this->updated_at,
                        'deleted_at'    => $this->deleted_at,*/
        ];
    }
}
