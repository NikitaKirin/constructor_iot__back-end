<?php

namespace App\Http\Resources\SocialNetworksBlock;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\SocialNetworksBlock */
class SocialNetworksBlockResource extends JsonResource
{
    public static $wrap = 'social_networks_block';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'        => $this->id,
            'data'      => $this->data,
            'institute' => $this->institute->abbreviation,
        ];
    }
}
