<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeddingReceptionUpdateRequest;
use App\Services\WeddingReceptionService;

class WeddingReceptionController extends Controller
{
    private $weddingReceptionService;

    public function __construct(WeddingReceptionService $weddingReceptionService)
    {
        $this->weddingReceptionService = $weddingReceptionService;
    }

    public function show(int $id)
    {
        $data = $this->weddingReceptionService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function update(int $id, WeddingReceptionUpdateRequest $request)
    {
        $this->weddingReceptionService->update($id, $request);
        return response()->json(['message' => 'wedding reception success updated']);
    }
}
