<?php

namespace App\Http\Resources\Invitation;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
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
            'image_hero_url' => url('/') . $this->image_hero_path,
            'slug' => $this->slug,
            'theme' => $this->theme_id,
        ];
    }
}
