<?php

namespace App\Services\File;

use App\Http\Requests\File\ImageRequest;
use App\Http\Requests\File\ImagesRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Image;

class FileService
{
    public function uploadImage(ImageRequest $request, string $type)
    {
        $path = '/image/' . $type . '/' . Str::random(36) . '.webp';
        $this->convertToWebp($request->file('image'), $path);
        return $path;
    }

    public function uploadImages(ImagesRequest $request, string $type)
    {
        $files = $request->file('images');
        if (!$request->hasFile('images')) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'image[] required'
                ]
            ], 400));
        }
        if ($files instanceof UploadedFile) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'use image[] instead image'
                ]
            ], 400));
        }
        $paths = [];
        foreach ($files as $file) {
            $path = '/image/' . $type . '/' . Str::random(36) . '.webp';
            $this->convertToWebp($file, $path);
            array_push($paths, $path);
        }
        return $paths;
    }

    private function convertToWebp(UploadedFile $image, string $path)
    {
        Image::make($image)
            ->encode('webp')
            ->save(public_path() . $path);
    }
}