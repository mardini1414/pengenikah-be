<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroomUpdateRequest;
use App\Services\Invitation\GroomService;

class GroomController extends Controller
{
    private $groomService;

    public function __construct(GroomService $groomService)
    {
        $this->groomService = $groomService;
    }

    public function show(int $id)
    {
        $data = $this->groomService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function update(int $id, GroomUpdateRequest $request)
    {
        $this->groomService->update($id, $request);
        return response()->json(['message' => 'groom success updated']);
    }
}
