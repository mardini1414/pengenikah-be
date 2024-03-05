<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\GalleryCreateRequest;
use App\Http\Requests\Invitation\GalleryUpdateRequest;
use App\Http\Resources\Invitation\GalleryResource;
use App\Models\Invitation\Gallery;
use App\Models\Invitation\Invitation;
use Illuminate\Http\Exceptions\HttpResponseException;

class GalleryService
{

    public function getByInvitationId(int $id)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        $data = Gallery::where('invitation_id', $id)->get();
        return GalleryResource::collection($data);
    }

    public function create(GalleryCreateRequest $request)
    {
        $invitation = Invitation::where('id', $request['invitationId'])->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        Gallery::insert([
            'image_path' => $request['image'],
            'invitation_id' => $request['invitationId'],
        ]);
    }

    public function update(int $id, GalleryUpdateRequest $request)
    {
        $gallery = Gallery::where('id', $id)->count();
        if ($gallery < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'gallery id not found'
                ]
            ], 404));
        }
        Gallery::where('id', $id)
            ->update(
                [
                    'image_path' => $request['image']
                ]
            );
    }

    public function delete(int $id)
    {
        $gallery = Gallery::where('id', $id)->count();
        if ($gallery < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'gallery id not found'
                ]
            ], 404));
        }
        Gallery::where('id', $id)->delete();
    }
}