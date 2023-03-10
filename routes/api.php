<?php

use App\Http\Controllers\AssetsController;

use App\Http\Controllers\CardsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

//Route::get('users', [UsersController::class, 'users']);


Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
    Route::get('verify/{verificationToken}', [UsersController::class, 'verifyEmail']);
    Route::post('/resetpasswordrequest', [UsersController::class, 'resetPasswordRequest']);
    Route::post('/resetpassword', [UsersController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    Route::post('/refresh', [UsersController::class, 'refresh']);
    Route::get('/profile/show/{id}', [UsersController::class, 'getUser']);
    Route::patch('/profile/update/{id}', [UsersController::class, 'updateProfile']);
    Route::patch('/profile/changePassword/{id}', [UsersController::class, 'changePassword']);
    Route::delete('/profile/deleteAccount/{id}', [UsersController::class, 'deleteAccount']);
    Route::post('/addcard', [CardsController::class, 'addCard']);
    Route::get('/cards/{id}', [CardsController::class, 'showCardById']);
    Route::delete('delete/{id}', [CardsController::class, 'destroy']);
    Route::get('/assets', [AssetsController::class, 'getUserAssets']);
    Route::post('/createasset', [AssetsController::class, 'createNewAssets']);
});


Route::middleware(['auth:sanctum', 'can:isAdmin'])->prefix('/admin')->group(function () {
    Route::get('/bill', [BillController::class, 'index']);
    Route::post('/bill/add', [BillController::class, 'addBill']);
    Route::get('/bill/show/{id}', [BillController::class, 'show']);
    Route::get('/users', [UsersController::class, 'users']);
    Route::get('/assets', [AssetsController::class, 'showAllUserAssetsToAdmin']);
    Route::patch('/assets/adminDocumentsConfirmation', [AssetsController::class, 'adminDocumentsConfirmation']);
});