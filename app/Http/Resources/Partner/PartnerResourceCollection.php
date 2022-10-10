<?php

namespace App\Http\Resources\Partner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Partner */
class PartnerResourceCollection extends ResourceCollection
{
    public static $wrap = 'partners';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            PartnerResourceCollection::$wrap => $this->collection,
        ];
    }
}
