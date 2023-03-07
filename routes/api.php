<?php

use App\Http\Controllers\AssetsController;

use App\Http\Controllers\CardsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::get('users', [UsersController::class, 'users']);


Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
    Route::get('verify/{verificationToken}', [UsersController::class, 'verifyEmail']);
});


Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    Route::post('/refresh', [UsersController::class, 'refresh']);

    Route::post('/addcard', [CardsController::class, 'addCard']);
    Route::get('/cards/{id}', [CardsController::class, 'showCardById']);
    Route::delete('delete/{id}', [CardsController::class, 'destroy']);
});
Route::middleware(['auth:sanctum', 'can:isAdmin'])->prefix('/admin')->group(function () {
    Route::get('users', [UsersController::class, 'users']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/assets', [AssetsController::class, 'getUserAssets']);
    Route::post('/createasset', [AssetsController::class, 'createNewAssets']);
});