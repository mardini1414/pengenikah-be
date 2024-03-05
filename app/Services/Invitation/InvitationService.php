<?php

namespace App\Services\Invitation;

use App\Http\Requests\Invitation\InvitationCreateRequest;
use App\Http\Requests\Invitation\InvitationUpdateRequest;
use App\Http\Resources\Invitation\InvitationDetailResource;
use App\Http\Resources\Invitation\InvitationResource;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invitation\AlsoInvite;
use App\Models\Invitation\Bride;
use App\Models\Invitation\Gallery;
use App\Models\Invitation\Groom;
use App\Models\Invitation\Invitation;
use App\Models\Invitation\Story;
use App\Models\Invitation\WeddingCeremony;
use App\Models\Invitation\WeddingReception;
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
                'wedding_ceremonies.date as ceremony',
                'wedding_receptions.date as reception',
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
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        $data = Invitation::where('id', $id)->first();
        return new InvitationResource($data);
    }

    public function getBySlug(string $slug)
    {
        $invitation = Invitation::where('slug', $slug)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation not found'
                ]
            ], 404));
        }
        $relations = [
            'song',
            'bride',
            'groom',
            'weddingCeremony',
            'weddingReception',
            'alsoInvites',
            'galleries',
            'stories'
        ];
        $data = Invitation::with($relations)->where('slug', $slug)->first();
        return new InvitationDetailResource($data);
    }
    public function create(InvitationCreateRequest $invitationRequest)
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

    public function update(int $id, InvitationUpdateRequest $request)
    {
        $invitation = Invitation::where('id', $id)->count();
        if ($invitation < 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'invitation id not found'
                ]
            ], 404));
        }
        try {
            Invitation::where('id', $id)
                ->update([
                    'image_hero_path' => $request['heroImage'],
                    'theme_id' => $request['themeId'],
                    'song_id' => $request['songId'],
                ]);
        } catch (QueryException $ex) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'theme id or song id not found'
                ]
            ], 404));
        }
    }

    public function getTotalPerMonth(?int $year)
    {
        $data = Invitation::selectRaw('count(*) as total, month(created_at) as month')
            ->whereRaw('year(created_at) = ?', [$year ?? date('Y')])
            ->groupByRaw('month(created_at)')
            ->orderByRaw('month(created_at)')
            ->get();
        return $this->mappingTotatPerMonth($data);

    }

    private function mappingTotatPerMonth(object $data)
    {
        $dataPerMonth = [
            [
                'key' => 1,
                'total' => 0,
                'month' => 'January'
            ],
            [
                'key' => 2,
                'total' => 0,
                'month' => 'February'
            ],
            [
                'key' => 3,
                'total' => 0,
                'month' => 'March'
            ],
            [
                'key' => 4,
                'total' => 0,
                'month' => 'April'
            ],
            [
                'key' => 5,
                'total' => 0,
                'month' => 'May'
            ],
            [
                'key' => 6,
                'total' => 0,
                'month' => 'Juny'
            ],
            [
                'key' => 7,
                'total' => 0,
                'month' => 'July'
            ],
            [
                'key' => 8,
                'total' => 0,
                'month' => 'August'
            ],
            [
                'key' => 9,
                'total' => 0,
                'month' => 'September'
            ],
            [
                'key' => 10,
                'total' => 0,
                'month' => 'October'
            ],
            [
                'key' => 11,
                'total' => 0,
                'month' => 'November'
            ],
            [
                'key' => 12,
                'total' => 0,
                'month' => 'December'
            ],
        ];

        $result = array_map(function ($v) use ($data) {
            foreach ($data as $d) {
                if ($v['key'] === $d->month) {
                    $v['total'] = $d->total;
                }
            }
            return [
                'total' => $v['total'],
                'month' => $v['month']
            ];
        }, $dataPerMonth);

        return $result;
    }
}