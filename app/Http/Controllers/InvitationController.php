<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Services\InvitationService;
use Illuminate\Http\Request;


class InvitationController extends Controller
{
    private $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function index(Request $request)
    {
        $data = $this->invitationService->get($request);
        return response()->json($data);
    }

    public function store(InvitationRequest $request)
    {
        $this->invitationService->create($request);
        return response()->json([
            'message' => 'Invitation success created'
        ], 201);
    }

    public function show(int $id)
    {
        $data = $this->invitationService->getOne($id);
        return response()->json($data);
    }

    public function update()
    {
        //
    }
}
