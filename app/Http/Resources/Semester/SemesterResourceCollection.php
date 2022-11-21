<?php

namespace App\Http\Resources\Semester;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Semester */
class SemesterResourceCollection extends ResourceCollection
{
    public static $wrap = 'semesters';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'semesters' => $this->collection,
        ];
    }
}
