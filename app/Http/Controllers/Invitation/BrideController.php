<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\BrideUpdateRequest;
use App\Services\Invitation\BrideService;

class BrideController extends Controller
{

    private $brideService;

    public function __construct(BrideService $brideService)
    {
        $this->brideService = $brideService;
    }

    public function show(int $id)
    {
        $data = $this->brideService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function update(int $id, BrideUpdateRequest $request)
    {
        $this->brideService->update($id, $request);
        return response()->json(['message' => 'bride success updated']);
    }
}
