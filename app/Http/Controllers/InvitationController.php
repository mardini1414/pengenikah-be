<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationCreateRequest;
use App\Http\Requests\InvitationUpdateRequest;
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

    public function store(InvitationCreateRequest $request)
    {
        $this->invitationService->create($request);
        return response()->json(['message' => 'invitation success created'], 201);
    }

    public function show(int $id)
    {
        $data = $this->invitationService->getOne($id);
        return response()->json(['data' => $data]);
    }

    public function getDetail(int $id)
    {
        $data = $this->invitationService->getDetail($id);
        return response()->json($data);
    }

    public function update(int $id, InvitationUpdateRequest $request)
    {
        $this->invitationService->update($id, $request);
        return response()->json(['message' => 'invitation success updated']);
    }

    public function getTotalPerMonth(Request $request)
    {
        $data = $this->invitationService->getTotalPerMonth($request->year);
        return response()->json(['data' => $data]);
    }
}
