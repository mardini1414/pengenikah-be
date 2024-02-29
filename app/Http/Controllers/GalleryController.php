<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryCreateRequest;
use App\Http\Requests\GalleryUpdateRequest;
use App\Services\GalleryService;

class GalleryController extends Controller
{

    private $gallerService;

    public function __construct(GalleryService $galleryService)
    {
        $this->gallerService = $galleryService;
    }

    public function show(int $id)
    {
        $data = $this->gallerService->getByInvitationId($id);
        return response()->json(['data' => $data]);
    }

    public function store(GalleryCreateRequest $request)
    {
        $this->gallerService->create($request);
        return response()->json(['message' => 'gallery success created'], 201);
    }

    public function update(int $id, GalleryUpdateRequest $request)
    {
        $this->gallerService->update($id, $request);
        return response()->json(['message' => 'gallery success updated']);
    }

    public function destroy(int $id)
    {
        $this->gallerService->delete($id);
        return response()->json(['message' => 'gallery success deleted']);
    }
}
