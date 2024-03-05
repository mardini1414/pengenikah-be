<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\CommentCreateRequest;
use App\Services\Invitation\CommentService;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function show(int $id)
    {
        $data = $this->commentService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function store(CommentCreateRequest $request)
    {
        $this->commentService->create($request);
        return response()->json(['message' => 'comment success created'], 201);
    }
}
