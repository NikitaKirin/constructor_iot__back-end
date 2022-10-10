<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Review */
class ReviewResourceCollection extends ResourceCollection
{
    public static $wrap = 'reviews';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            self::$wrap => $this->collection,
        ];
    }
}
