<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{

    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function uploadImageHero(Request $request)
    {
        $path = $this->fileService->uploadImage($request, 'hero');
        return response()->json([
            'message' => 'upload success',
            'path' => $path
        ]);
    }

    public function uploadImageAvatar(Request $request)
    {
        $path = $this->fileService->uploadImage($request, 'avatar');
        return response()->json([
            'message' => 'upload success',
            'path' => $path
        ]);
    }

    public function uploadImageGallery(Request $request)
    {
        $paths = $this->fileService->uploadImages($request, 'gallery');
        return response()->json([
            'message' => 'upload success',
            'paths' => $paths
        ]);
    }
}
