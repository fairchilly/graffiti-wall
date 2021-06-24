<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('posts')->group(function () {
    Route::get('/archive-summary', [PostController::class, 'archiveSummary']);

    Route::get('', [PostController::class, 'list']);
    Route::post('', [PostController::class, 'create']);
    Route::get('/{post}', [PostController::class, 'details']);
    Route::put('/{post}', [PostController::class, 'update']);
    Route::delete('/{post}', [PostController::class, 'delete']);
});

Route::prefix('tags')->group(function () {
    Route::get('/trending/{top_count?}', [TagController::class, 'trending']);
    Route::get('/{tag}', [TagController::class, 'posts']);
});

Route::prefix('users')->group(function () {
    Route::get('/{user}/posts', [UserController::class, 'posts']);
});