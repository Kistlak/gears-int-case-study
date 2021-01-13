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
Route::post('/search_results', [\App\Http\Controllers\AuthorController::class, 'search_results']);
Route::post('/register_user', [\App\Http\Controllers\AuthorController::class, 'register_user']);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::middleware(['auth:api', 'role'])->group(function() {
    // List users
    Route::middleware(['scope:admin,author'])->get('/users', function (Request $request) {
        return \App\Models\User::get();
    });

//    Route::middleware(['scope:admin,author'])->post('/search_results', [\App\Http\Controllers\AuthorController::class, 'search_results']);

    Route::middleware(['scope:admin,author'])->get('/all_books', [\App\Http\Controllers\AuthorController::class, 'all_books']);

    Route::middleware(['scope:author'])->post('/add_books', [\App\Http\Controllers\AuthorController::class, 'add_books']);
    Route::middleware(['scope:author'])->post('/edit_books', [\App\Http\Controllers\AuthorController::class, 'edit_books']);
    Route::middleware(['scope:author'])->post('/delete_books', [\App\Http\Controllers\AuthorController::class, 'delete_books']);

    Route::middleware(['scope:admin'])->get('/all_users', [\App\Http\Controllers\AuthorController::class, 'all_users']);
    Route::middleware(['scope:admin'])->post('/change_status', [\App\Http\Controllers\AuthorController::class, 'change_status']);
});
