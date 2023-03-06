<?php

use App\Http\Controllers\TransactionsController;
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

Route::group(['prefix'=>'transaction'],function () {
    Route::get('/{id}',[TransactionsController::class, 'index']);
    Route::post('/money',[TransactionsController::class,'MoneyTransaction']);
    Route::post('/asset',[TransactionsController::class,'AssetTransaction']);
    Route::post('/bill',[TransactionsController::class,'BillTransaction']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
