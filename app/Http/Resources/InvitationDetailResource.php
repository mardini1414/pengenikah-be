<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationDetailResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'image_hero_url' => url('/') . $this->image_hero_path,
                'slug' => $this->slug,
                'theme' => $this->theme_id,
                'song_url' => url('/') . $this->song->path,
                'bride' => new BrideResources($this->bride),
                'groom' => new GroomResources($this->groom),
                'wedding_ceremony' => new WeddingCeremonyResource($this->weddingCeremony),
                'wedding_reception' => new WeddingReceptionResource($this->weddingReception),
                'also_invites' => AlsoInviteResource::collection($this->alsoInvites),
                'galleries' => GalleryResource::collection($this->galleries),
                'stories' => StoryResource::collection($this->stories)
            ]
        ];
    }
}
