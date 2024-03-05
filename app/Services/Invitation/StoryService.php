<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\StoryCreateRequest;
use App\Http\Requests\Invitation\StoryUpdateRequest;
use App\Http\Resources\Invitation\StoryResource;
use App\Models\Invitation\Invitation;
use App\Models\Invitation\Story;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoryService
{

    public function getByInvitationId(int $id)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        $data = Story::where('invitation_id', $id)->get();
        return StoryResource::collection($data);
    }

    public function create(StoryCreateRequest $request)
    {
        $invitation = Invitation::where('id', $request['invitationId'])->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        Story::insert([
            'title' => $request['title'],
            'text' => $request['text'],
            'invitation_id' => $request['invitationId']
        ]);
    }

    public function update(int $id, StoryUpdateRequest $request)
    {
        $story = Story::where('id', $id)->count();
        if ($story < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'story id not found'
                ]
            ], 404));
        }
        Story::where('id', $id)
            ->update(
                [
                    'title' => $request['title'],
                    'text' => $request['text'],
                ]
            );
    }

    public function delete(int $id)
    {
        $story = Story::where('id', $id)->count();
        if ($story < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'story id not found'
                ]
            ], 404));
        }
        Story::where('id', $id)->delete();
    }
}