<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\ImageRequest;
use App\Http\Requests\File\ImagesRequest;
use App\Services\File\FileService;

class FileController extends Controller
{

    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function uploadImageHero(ImageRequest $request)
    {
        $path = $this->fileService->uploadImage($request, 'hero');
        return response()->json([
            'message' => 'upload success',
            'path' => $path
        ]);
    }

    public function uploadImageAvatar(ImageRequest $request)
    {
        $path = $this->fileService->uploadImage($request, 'avatar');
        return response()->json([
            'message' => 'upload success',
            'path' => $path
        ]);
    }

    public function uploadImageGallery(ImagesRequest $request)
    {
        $paths = $this->fileService->uploadImages($request, 'gallery');
        return response()->json([
            'message' => 'upload success',
            'paths' => $paths
        ]);
    }
}
