<?php

namespace App\Http\Resources\CourseAssembly;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\CourseAssembly */
class CourseAssemblyResourceCollection extends ResourceCollection
{
    public static $wrap = 'course_assemblies';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'course_assemblies' => $this->collection,
        ];
    }
}
