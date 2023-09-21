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

Route::post('/register', 'RegisterController@register');

Route::post('/login', 'RegisterController@login');

Route::post('/google/login', 'LoginController@login');

Route::post('/resetOtp', 'LoginController@sendResetOtpEmail');
    
Route::post('/verifyOtp', 'LoginController@verifyOtp');

Route::post('/resetPassword', 'LoginController@resetPassword');

Route::post('/changePassword', 'LoginController@changePassword');


Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('/logout', 'LoginController@logout');

    Route::get('/users', 'UserController@index');

    Route::get('/user', 'UserController@profile');

    Route::post('/updateStatus', 'UserController@updateStatus');

    Route::post('/stopTimer', 'UserController@stopTimer');

    Route::post('/user/{keyword}/search', 'UserController@search');

    Route::get('/logs', 'UserStatusLogController@index');

});
