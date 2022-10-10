<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

/** @mixin \App\Models\Review */
class ReviewResource extends JsonResource
{
    public static $wrap = 'review';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'                     => $this->id,
            'author'                 => $this->author,
            'text'                   => $this->text,
            'additional_information' => $this->additional_information,
            'photo_id'               => $this->photo?->url() ?? Config::get('constants.avatar.url'),
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
