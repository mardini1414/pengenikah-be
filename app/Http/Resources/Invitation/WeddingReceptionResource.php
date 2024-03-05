<?php

namespace App\Http\Resources\Invitation;

use Illuminate\Http\Resources\Json\JsonResource;

class WeddingReceptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'address' => $this->address,
            'google_map' => $this->google_map,
        ];
    }
}
