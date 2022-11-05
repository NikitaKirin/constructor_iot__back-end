<?php

namespace App\Http\Resources\SocialNetworksBlock;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\SocialNetworksBlock */
class SocialNetworksBlockResource extends JsonResource
{
    public static $wrap = 'social_networks_block';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ): array {
        return [
            'id'        => $this->id,
            'data'      => $this->formatArray($this->data),
            'institute' => $this->institute->abbreviation,
        ];
    }


    private function formatArray( array $array ): array {
        return [
            [
                'name' => 'Telegram',
                'url'  => $array['Telegram']['url'],
                'icon' => $array['Telegram']['icon'],
            ],

            [
                'name' => 'ВКонтакте',
                'url'  => $array['ВКонтакте']['url'],
                'icon' => $array['ВКонтакте']['icon'],
            ],
        ];
    }
}
