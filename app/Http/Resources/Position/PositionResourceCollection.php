<?php

namespace App\Http\Resources\Position;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Position */
class PositionResourceCollection extends ResourceCollection
{
    public static $wrap = 'positions';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'positions' => $this->collection,
        ];
    }
}
