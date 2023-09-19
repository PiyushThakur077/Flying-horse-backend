<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusLogController;
use App\Http\Controllers\WalletController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [RegisterController::class, 'login']);

Route::post('/google/login', [LoginController::class, 'login']);

Route::post('/resetOtp', [LoginController::class, 'sendResetOtpEmail']);
    
Route::post('/verifyOtp', [LoginController::class, 'verifyOtp']);

Route::post('/resetPassword', [LoginController::class, 'resetPassword']);

Route::post('/changePassword', [LoginController::class, 'changePassword']);


Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/user', [UserController::class, 'profile']);

    Route::post('/updateStatus', [UserController::class, 'updateStatus']);

    Route::post('/stopTimer', [UserController::class, 'stopTimer']);

    Route::post('/user/{keyword}/search', [UserController::class, 'search']);

    Route::get('/logs', [UserStatusLogController::class, 'index']);

});
