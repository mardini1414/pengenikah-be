<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::delete('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');
});

Route::prefix('invitation')->group(function () {
    Route::get('', [InvitationController::class, 'index']);
    Route::get('{id}', [InvitationController::class, 'show']);
    Route::post('', [InvitationController::class, 'store']);
});

Route::prefix('file')->group(function () {
    Route::post('image-hero/upload', [FileController::class, 'uploadImageHero']);
    Route::post('avatar/upload', [FileController::class, 'uploadImageAvatar']);
    Route::post('gallery/upload', [FileController::class, 'uploadImageGallery']);
});

