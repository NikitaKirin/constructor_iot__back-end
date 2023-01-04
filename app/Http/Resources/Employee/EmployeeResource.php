<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\Position\PositionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\assertJson;

/** @mixin \App\Models\Employee */
class EmployeeResource extends JsonResource
{
    public static $wrap = 'employee';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'audience' => $this->audience,
            'additional_information' => $this->additional_information,
            'photo' => $this->photo->url() ?? asset('img/avatar.png'),
            'position' => new PositionResource($this->whenLoaded('position')),
        ];
    }
}
