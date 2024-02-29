<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

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
