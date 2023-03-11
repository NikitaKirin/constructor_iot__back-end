<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\FAQ */
class FAQResourceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */

    public static $wrap = 'FAQ';
    public function toArray($request) {
        return [
            'FAQ' => $this->collection,
        ];
    }
}
