<?php

namespace App\Http\Resources\Partner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Partner */
class PartnerResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'logo_id'       => $this->logo_id,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'deleted_at'    => $this->deleted_at,
            'courses_count' => $this->courses_count,

            'user_id' => $this->user_id,
        ];
    }
}
