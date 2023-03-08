<?php

namespace App\Http\Resources\EducationalProgram;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\EducationalProgram */
class EducationalProgramResourceCollection extends ResourceCollection
{
    public static $wrap = 'educational_programs';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'educational_programs' => $this->collection,
        ];
    }
}
