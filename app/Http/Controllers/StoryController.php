<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoryCreateRequest;
use App\Http\Requests\StoryUpdateRequest;
use App\Services\StoryService;

class StoryController extends Controller
{
    private $storyService;

    public function __construct(StoryService $storyService)
    {
        $this->storyService = $storyService;
    }

    public function show(int $id)
    {
        $data = $this->storyService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function store(StoryCreateRequest $request)
    {
        $this->storyService->create($request);
        return response()->json(['message' => 'story success created'], 201);
    }

    public function update(int $id, StoryUpdateRequest $request)
    {
        $this->storyService->update($id, $request);
        return response()->json(['message' => 'story success updated']);
    }

    public function destroy(int $id)
    {
        $this->storyService->delete($id);
        return response()->json(['message' => 'story success deleted']);
    }
}
