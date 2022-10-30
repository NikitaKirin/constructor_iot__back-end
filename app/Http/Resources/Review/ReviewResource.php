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
            'id'                    => $this->id,
            'author'                => $this->author,
            'text'                  => $this->text,
            'educational_direction' => $this->educational_direction,
            'course'                => $this->course,
            'year_of_issue'         => $this->year_of_issue,
            'photo'                 => $this->photo?->url() ?? Config::get('constants.avatar.url'),
        ];
    }
}
