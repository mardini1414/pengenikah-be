<?php

use App\Http\Controllers\Invitation\AlsoInviteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Invitation\BrideController;
use App\Http\Controllers\Invitation\CommentController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Invitation\GalleryController;
use App\Http\Controllers\Invitation\GroomController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\Invitation\StoryController;
use App\Http\Controllers\Summary\SummaryController;
use App\Http\Controllers\Invitation\WeddingCeremonyController;
use App\Http\Controllers\Invitation\WeddingReceptionController;
use App\Http\Controllers\User\UserController;
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
});

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('authenticated', [UserController::class, 'getAuthenticated']);
});

Route::prefix('summaries')->middleware('auth:sanctum')->group(function () {
    Route::get('', [SummaryController::class, 'index']);
});

Route::prefix('invitations')->group(function () {
    Route::get('', [InvitationController::class, 'index'])->middleware('auth:sanctum');
    Route::get('total-per-month', [InvitationController::class, 'getTotalPerMonth'])->middleware('auth:sanctum');
    Route::get('detail/{slug}', [InvitationController::class, 'getByslug']);
    Route::get('{id}', [InvitationController::class, 'show'])->middleware('auth:sanctum');
    Route::post('', [InvitationController::class, 'store'])->middleware('auth:sanctum');
    Route::put('{id}', [InvitationController::class, 'update'])->middleware('auth:sanctum');
});

Route::prefix('brides')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [BrideController::class, 'show']);
    Route::put('{invitationId}', [BrideController::class, 'update']);
});

Route::prefix('grooms')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [GroomController::class, 'show']);
    Route::put('{invitationId}', [GroomController::class, 'update']);
});

Route::prefix('wedding-ceremonies')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [WeddingCeremonyController::class, 'show']);
    Route::put('{invitationId}', [WeddingCeremonyController::class, 'update']);
});

Route::prefix('wedding-receptions')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [WeddingReceptionController::class, 'show']);
    Route::put('{invitationId}', [WeddingReceptionController::class, 'update']);
});

Route::prefix('galleries')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [GalleryController::class, 'show']);
    Route::post('', [GalleryController::class, 'store']);
    Route::put('{id}', [GalleryController::class, 'update']);
    Route::delete('{id}', [GalleryController::class, 'destroy']);
});

Route::prefix('stories')->middleware('auth:sanctum')->group(function () {
    Route::post('', [StoryController::class, 'store']);
    Route::get('{invitationId}', [StoryController::class, 'show']);
    Route::put('{id}', [StoryController::class, 'update']);
    Route::delete('{id}', [StoryController::class, 'destroy']);
});

Route::prefix('also-invites')->middleware('auth:sanctum')->group(function () {
    Route::get('{invitationId}', [AlsoInviteController::class, 'show']);
    Route::post('', [AlsoInviteController::class, 'store']);
    Route::put('{id}', [AlsoInviteController::class, 'update']);
    Route::delete('{id}', [AlsoInviteController::class, 'destroy']);
});

Route::prefix('comments')->group(function () {
    Route::get('{invitationId}', [CommentController::class, 'show']);
    Route::post('', [CommentController::class, 'store']);
});

Route::prefix('file')->middleware('auth:sanctum')->group(function () {
    Route::post('image-hero/upload', [FileController::class, 'uploadImageHero']);
    Route::post('avatar/upload', [FileController::class, 'uploadImageAvatar']);
    Route::post('gallery/upload', [FileController::class, 'uploadImageGallery']);
});

