<?php

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

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/results', [\App\Http\Controllers\SearchResultController::class, 'index']);
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('/users/{id}/books', [\App\Http\Controllers\UsersBookController::class, 'show']);

Route::middleware(['auth:api'])->group(function() {
//    Route::middleware(['scope:admin,author'])->get('/books', [\App\Http\Controllers\BookController::class, 'index']);
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index']);
    Route::post('/books', [\App\Http\Controllers\BookController::class, 'store']);
    Route::put('/books/{book}', [\App\Http\Controllers\BookController::class, 'update']);
    Route::delete('/books/{book}', [\App\Http\Controllers\BookController::class, 'destroy']);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);

    Route::put('/users/{id}/status', [\App\Http\Controllers\AuthorStatusController::class, 'update']);
});
