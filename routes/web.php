<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin/login');
})->middleware('guest');


Route::get('/login', function () {
    return redirect('admin/login');
})->middleware('guest');


Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login')->middleware('guest');;
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', function () {
        return redirect('admin/dashboard');
    });
    Route::get('/admin/dashboard', function(){
        return view('admin.users.view');
    })->name('admin.dashboard');

    Route::get('/admin/users', function(){
        return view('admin.users.view');
    })->name('users');

    Route::post('/users/datatable',  [UserController::class, 'datatable'])->name('users.datatable');
    Route::post('/users/data',  [UserController::class, 'userList'])->name('users.data');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::match(['put', 'post'], '/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}',  [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/teams', function(){ return view('admin.teams.view'); })->name('admin.teams');
    Route::post('/admin/teams/create', [UserController::class, 'createTeam'])->name('admin.teams.create');
    Route::get('/admin/teams', [UserController::class, 'showTeams'])->name('admin.teams');

});
