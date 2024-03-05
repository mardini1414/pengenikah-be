<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\AlsoInviteCreateRequest;
use App\Http\Requests\Invitation\AlsoInviteUpdateRequest;
use App\Http\Resources\Invitation\AlsoInviteResource;
use App\Models\Invitation\AlsoInvite;
use App\Models\Invitation\Invitation;
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