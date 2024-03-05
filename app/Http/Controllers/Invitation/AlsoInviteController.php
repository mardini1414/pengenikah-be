<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\AlsoInviteCreateRequest;
use App\Http\Requests\Invitation\AlsoInviteUpdateRequest;
use App\Services\Invitation\AlsoInviteService;

class AlsoInviteController extends Controller
{

    private $alsoInviteService;

    public function __construct(AlsoInviteService $alsoInviteService)
    {
        $this->alsoInviteService = $alsoInviteService;
    }

    public function show(int $id)
    {
        $data = $this->alsoInviteService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function store(AlsoInviteCreateRequest $request)
    {
        $this->alsoInviteService->create($request);
        return response()->json(['message' => 'also invite success created'], 201);
    }

    public function update(int $id, AlsoInviteUpdateRequest $request)
    {
        $this->alsoInviteService->update($id, $request);
        return response()->json(['message' => 'also invite success updated']);
    }

    public function destroy(int $id)
    {
        $this->alsoInviteService->delete($id);
        return response()->json(['message' => 'also invite success deleted']);
    }
}
