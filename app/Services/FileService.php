<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Image;

class FileService
{
    public function uploadImage(Request $request, string $type)
    {
        $path = '/image/' . $type . '/' . Str::random(36) . '.webp';
        $this->convertToWebp($request->file('image'), $path);
        return $path;
    }

    public function uploadImages(Request $request, string $type)
    {
        $files = $request->file('images');
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