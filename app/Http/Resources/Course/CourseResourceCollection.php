<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Course */
class CourseResourceCollection extends ResourceCollection
{
    public static $wrap = 'courses';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'courses' => $this->collection,
        ];
    }
}
