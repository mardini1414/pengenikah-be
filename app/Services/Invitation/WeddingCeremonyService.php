<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\WeddingCeremonyUpdateRequest;
use App\Http\Resources\Invitation\WeddingCeremonyResource;
use App\Models\Invitation\Invitation;
use App\Models\Invitation\WeddingCeremony;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class WeddingCeremonyService
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
        $data = WeddingCeremony::where('invitation_id', $id)->first();
        return new WeddingCeremonyResource($data);
    }

    public function update(int $id, WeddingCeremonyUpdateRequest $request)
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
        WeddingCeremony::where('invitation_id', $id)
            ->update(
                [
                    'date' => $date,
                    'address' => $request['address'],
                    'google_map' => $request['googleMap'],
                ]
            );
    }
}