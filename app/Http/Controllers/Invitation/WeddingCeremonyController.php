<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\WeddingCeremonyUpdateRequest;
use App\Services\Invitation\WeddingCeremonyService;

class WeddingCeremonyController extends Controller
{

    private $weddingCeremonyService;

    public function __construct(WeddingCeremonyService $weddingCeremonyService)
    {
        $this->weddingCeremonyService = $weddingCeremonyService;
    }

    public function show(int $id)
    {
        $data = $this->weddingCeremonyService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function update(int $id, WeddingCeremonyUpdateRequest $request)
    {
        $this->weddingCeremonyService->update($id, $request);
        return response()->json(['message' => 'wedding ceremony success updated']);
    }
}
