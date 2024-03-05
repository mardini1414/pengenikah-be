<?php

namespace App\Http\Resources\Invitation;

use Illuminate\Http\Resources\Json\JsonResource;

class BrideResources extends JsonResource
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
            'name' => $this->name,
            'instagram' => $this->instagram,
            'image_url' => url('/') . $this->image_path,
            'mother_name' => $this->mother_name,
            'father_name' => $this->father_name,
            'address' => $this->address
        ];
    }
}
