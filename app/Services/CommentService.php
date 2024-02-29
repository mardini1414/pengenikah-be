<?php

namespace App\Services;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Invitation;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentService
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
        $data = Comment::where('invitation_id', $id)->get();
        return CommentResource::collection($data);
    }

    public function create(CommentCreateRequest $request)
    {
        $invitation = Invitation::where('id', $request['invitationId'])->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        Comment::create([
            'invitation_id' => $request['invitationId'],
            'name' => $request['name'],
            'text' => $request['text']
        ]);
    }
}