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
});
Route::middleware(['auth:sanctum', 'can:isAdmin'])->prefix('/admin')->group(function () {


Route::get('/{id}/profile',[ProfileController::class,'show']);
// Route::get('/bill',[BillController::class,'index']);
// Route::post('admin/bill',[BillController::class,'create']);
Route::post('/bill',[BillController::class,'store'])->name("bill");;
});
