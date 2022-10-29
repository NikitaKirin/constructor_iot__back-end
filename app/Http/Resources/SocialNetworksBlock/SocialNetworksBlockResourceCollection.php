<?php

namespace App\Http\Resources\SocialNetworksBlock;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\SocialNetworksBlock */
class SocialNetworksBlockResourceCollection extends ResourceCollection
{
    public static $wrap = 'social_networks_blocks';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'social_networks_blocks' => $this->collection,
        ];
    }
}
