<?php

namespace App\Services;

use App\Http\Requests\AlsoInviteCreateRequest;
use App\Http\Requests\AlsoInviteUpdateRequest;
use App\Http\Resources\AlsoInviteResource;
use App\Models\AlsoInvite;
use App\Models\Invitation;
use Illuminate\Http\Exceptions\HttpResponseException;

class AlsoInviteService
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
        $data = AlsoInvite::where('invitation_id', $id)->get();
        return AlsoInviteResource::collection($data);
    }

    public function create(AlsoInviteCreateRequest $request)
    {
        $invitation = Invitation::where('id', $request['invitationId'])->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        AlsoInvite::insert([
            'name' => $request['name'],
            'invitation_id' => $request['invitationId']
        ]);
    }

    public function update(int $id, AlsoInviteUpdateRequest $request)
    {
        $alsoInvite = AlsoInvite::where('id', $id)->count();
        if ($alsoInvite < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'also invite id not found'
                ]
            ], 404));
        }
        AlsoInvite::where('id', $id)
            ->update([
                'name' => $request['name']
            ]);
    }

    public function delete(int $id)
    {
        $alsoInvite = AlsoInvite::where('id', $id)->count();
        if ($alsoInvite < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'also invite id not found'
                ]
            ], 404));
        }
        AlsoInvite::where('id', $id)
            ->delete();
    }
}