<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\WeddingReceptionUpdateRequest;
use App\Http\Resources\Invitation\WeddingReceptionResource;
use App\Models\Invitation\Invitation;
use App\Models\Invitation\WeddingReception;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class WeddingReceptionService
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
        $data = WeddingReception::where('invitation_id', $id)->first();
        return new WeddingReceptionResource($data);
    }

    public function update(int $id, WeddingReceptionUpdateRequest $request)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        $date = Carbon::parse($request['date'])->toDateTime();
        WeddingReception::where('invitation_id', $id)
            ->update(
                [
                    'date' => $date,
                    'address' => $request['address'],
                    'google_map' => $request['googleMap'],
                ]
            );
    }
}