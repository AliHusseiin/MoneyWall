<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BillController;

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




Route::group(['prefix'=>'user'], function() {
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
    Route::get('verify/{verificationToken}', [UsersController::class, 'verifyEmail']);



});
Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    Route::post('/refresh', [UsersController::class, 'refresh']);
    Route::patch('/profile/update/{id}', [UsersController::class, 'updateProfile']);
    Route::patch('/profile/changePassword/{id}', [UsersController::class, 'changePassword']);
    Route::delete('/profile/deleteAccount/{id}', [UsersController::class, 'deleteAccount']);
});

 Route::middleware(['auth:sanctum'])->prefix('/admin')->group(function () {
    Route::post('/bill/add',[BillController::class,'addBill']);
 });


