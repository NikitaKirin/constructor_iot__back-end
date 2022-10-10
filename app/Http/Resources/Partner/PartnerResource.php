<?php

namespace App\Http\Resources\Partner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

/** @mixin \App\Models\Partner */
class PartnerResource extends JsonResource
{
    public static $wrap = 'partner';
    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'logo'        => $this->logo?->url() ?? Config::get('constants.avatar.url'),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
