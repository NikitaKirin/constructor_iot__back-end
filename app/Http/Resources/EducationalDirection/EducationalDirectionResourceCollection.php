<?php

namespace App\Http\Resources\EducationalDirection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\EducationalDirection */
class EducationalDirectionResourceCollection extends ResourceCollection
{
    public static $wrap = 'educational_directions';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'educational_directions' => $this->collection,
        ];
    }
}
