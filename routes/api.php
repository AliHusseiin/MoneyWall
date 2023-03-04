<?php


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




Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
    Route::get('verify/{verificationToken}', [UsersController::class, 'verifyEmail']);
});
Route::group(['prefix' => 'credit-card'], function () {
    Route::post('/add', [CardsController::class, 'add']);
    Route::get('/cards', [CardsController::class, 'getCards']);
    Route::post('/{id}', [CardsController::class, 'show']);
    Route::delete('delete/{id}', [CardsController::class, 'destroy']);

});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
