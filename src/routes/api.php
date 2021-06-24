<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
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


// Post Routes
Route::prefix('posts')->group(function () {
    Route::get('/archive-summary', [PostController::class, 'archiveSummary']);
    Route::get('/year/{year}/month/{month}', [PostController::class, 'listByYearAndMonth']);

    Route::get('', [PostController::class, 'list']);
    Route::post('', [PostController::class, 'create']);
    Route::get('/{post}', [PostController::class, 'details']);

    // Protected Post Routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'delete']);
    });
});

// Tag Routes
Route::prefix('tags')->group(function () {
    Route::get('/trending/{top_count?}', [TagController::class, 'trending']);
    Route::get('/{tag}', [TagController::class, 'posts']);
});

// User Routes
Route::prefix('users')->group(function () {
    Route::get('/{user}/posts', [UserController::class, 'posts']);
    Route::get('/{user}/profile', [UserController::class, 'profile']);
});

// Authentication Routes
Route::prefix('authentication')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);

    // Protected Authentication Routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthenticationController::class, 'logout']);
    });
});