<?php

namespace App\Http\Resources\Partner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

/** @mixin \App\Models\Partner */
class PartnerResource extends JsonResource
{
    public static $wrap = 'partner';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'site_link' => $this->site_link,
            'logo'      => $this->logo?->url() ?? asset(Config::get('constants.avatars.employee.url')),
        ];
    }
}
