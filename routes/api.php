<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logut', [UserController::class, 'logout']);
    Route::apiResource('books', BookController::class)->except(['index', 'show']);

    Route::prefix('books/{book}/reviews')->group(function () {
        Route::post('/', [BookController::class, 'storeReview']);
        Route::delete('/', [BookController::class, 'deleteReview']);
    });
});

Route::prefix('public')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'store']);
    Route::apiResource('books', BookController::class)->except(['store', 'update', 'destory']);
    Route::get('books-report', [BookController::class, 'report']);
});
