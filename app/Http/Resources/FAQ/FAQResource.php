<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\FAQ */
class FAQResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */

    public static $wrap = 'FAQResource';
    public function toArray($request) {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
