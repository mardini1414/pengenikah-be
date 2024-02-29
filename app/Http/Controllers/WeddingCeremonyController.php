<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeddingCeremonyUpdateRequest;
use App\Services\WeddingCeremonyService;
use Illuminate\Http\Request;

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
