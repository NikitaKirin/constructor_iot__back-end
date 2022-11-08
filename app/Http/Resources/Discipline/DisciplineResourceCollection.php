<?php

namespace App\Http\Resources\Discipline;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Discipline */
class DisciplineResourceCollection extends ResourceCollection
{
    public static $wrap = 'disciplines';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'disciplines' => $this->collection,
        ];
    }
}
