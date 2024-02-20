<?php

namespace App\Services;

use App\Http\Requests\InvitationRequest;
use App\Http\Resources\InvitationResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AlsoInvite;
use App\Models\Bride;
use App\Models\Gallery;
use App\Models\Groom;
use App\Models\Invitation;
use App\Models\Story;
use App\Models\WeddingCeremony;
use App\Models\WeddingReception;
use Illuminate\Support\Facades\DB;

class InvitationService
{

    public function get(Request $request)
    {
        $name = $request->name;
        $startDate = $request->start_date ?? '1970-01-01';
        $endDate = $request->end_date ?? Carbon::now()->toDate();
        $result = DB::table('invitations')->select(
            [
                'invitations.slug',
                'brides.name as bride',
                'grooms.name as groom',
                'wedding_ceremonies.date as ceremonies',
                'wedding_receptions.date as receptions',
                'themes.name as theme',
                'songs.name as song',
                'invitations.created_at'
            ]
        )
            ->join('themes', 'invitations.theme_id', '=', 'themes.id')
            ->join('songs', 'invitations.song_id', '=', 'songs.id')
            ->join('brides', 'brides.invitation_id', '=', 'invitations.id')
            ->join('grooms', 'grooms.invitation_id', '=', 'invitations.id')
            ->join('wedding_ceremonies', 'wedding_ceremonies.invitation_id', '=', 'invitations.id')
            ->join('wedding_receptions', 'wedding_receptions.invitation_id', '=', 'invitations.id')
            ->whereBetween(DB::raw('date(invitations.created_at)'), [$startDate, $endDate])
            ->whereRaw("(brides.name like ? or grooms.name like ?)", [$name . '%', $name . '%'])
            ->latest('invitations.created_at')
            ->paginate(10);

        return [
            'data' => $result->items(),
            'pagination' => [
                'total' => $result->total(),
                'per_page' => $result->perPage(),
                'current_page' => $result->currentPage(),
            ]
        ];
    }

    public function getOne(int $id)
    {
        try {
            $data = Invitation::with([
                'song',
                'bride',
                'groom',
                'weddingCeremony',
                'weddingReception',
                'alsoInvites',
                'galleries',
                'stories'
            ])->findOrFail($id);
            return new InvitationResource($data);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation not found'
                ]
            ], 404));
        }
    }
    public function create(InvitationRequest $invitationRequest)
    {

        DB::transaction(function () use ($invitationRequest) {
            $request = $invitationRequest->validated();
            $brideName = $request['bride']['name'];
            $groomName = $request['groom']['name'];
            $ceremonyDate = Carbon::parse($request['weddingCeremony']['date'])->toDateTime();
            $receptionDate = Carbon::parse($request['weddingReception']['date'])->toDateTime();
            $slug = Str::slug($brideName . '-and-' . $groomName) . '-' . Str::random(10);

            $invitation = Invitation::create([
                'image_hero_path' => $request['heroImage'],
                'theme_id' => $request['themeId'],
                'song_id' => $request['songId'],
                'slug' => $slug,
            ]);

            Bride::insert([
                'name' => $brideName,
                'instagram' => $request['bride']['instagram'],
                'image_path' => $request['bride']['image'],
                'mother_name' => $request['bride']['motherName'],
                'father_name' => $request['bride']['fatherName'],
                'address' => $request['bride']['address'],
                'invitation_id' => $invitation->id,
            ]);

            Groom::insert([
                'name' => $groomName,
                'instagram' => $request['groom']['instagram'],
                'image_path' => $request['groom']['image'],
                'mother_name' => $request['groom']['motherName'],
                'father_name' => $request['groom']['fatherName'],
                'address' => $request['groom']['address'],
                'invitation_id' => $invitation->id,
            ]);

            WeddingCeremony::insert([
                'date' => $ceremonyDate,
                'address' => $request['weddingCeremony']['address'],
                'google_map' => $request['weddingCeremony']['googleMap'],
                'invitation_id' => $invitation->id,
            ]);

            WeddingReception::insert([
                'date' => $receptionDate,
                'address' => $request['weddingReception']['address'],
                'google_map' => $request['weddingReception']['googleMap'],
                'invitation_id' => $invitation->id,
            ]);

            $alsoInvites = array_map(function ($alsoInvite) use ($invitation) {
                return [
                    'name' => $alsoInvite['name'],
                    'invitation_id' => $invitation->id,
                ];
            }, $request['alsoInvites']);

            AlsoInvite::insert($alsoInvites);

            $stories = array_map(function ($story) use ($invitation) {
                return [
                    'title' => $story['title'],
                    'text' => $story['text'],
                    'invitation_id' => $invitation->id,
                ];
            }, $request['stories']);

            Story::insert($stories);

            $galleries = array_map(function ($gallery) use ($invitation) {
                return [
                    'image_path' => $gallery['image'],
                    'invitation_id' => $invitation->id,
                ];
            }, $request['galleries']);

            Gallery::insert($galleries);
        }, 5);
    }
}