<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Employee */
class EmployeeResourceCollection extends ResourceCollection
{
    public static $wrap = 'employees';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'employees' => $this->collection,
        ];
    }
}
