<?php

namespace App\Services;

use App\Http\Requests\GroomUpdateRequest;
use App\Http\Resources\GroomResources;
use App\Models\Bride;
use App\Models\Groom;
use App\Models\Invitation;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroomService
{
    public function getByInvitationId($id)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        $data = Groom::where('invitation_id', $id)->first();
        return new GroomResources($data);
    }

    public function update(int $id, GroomUpdateRequest $request)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }

        DB::transaction(function () use ($id, $request) {
            $bride = Bride::where('invitation_id', $id)->first();
            $slug = Str::slug($bride->name . '-and-' . $request['name']) . '-' . Str::random(10);

            Invitation::where('id', $id)->update([
                'slug' => $slug
            ]);

            Groom::where('invitation_id', $id)
                ->update([
                    'name' => $request['name'],
                    'instagram' => $request['instagram'],
                    'image_path' => $request['image'],
                    'mother_name' => $request['motherName'],
                    'father_name' => $request['fatherName'],
                    'address' => $request['address'],
                ]);
        });
    }
}