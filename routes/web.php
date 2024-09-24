<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('profile', ProfileController::class);

    Route::group(['middleware' => 'role:admin'], function () {
        // Admin routes
    });

    Route::middleware(['role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
        Route::resource('menu', MenuController::class);
    });

    // Route::group(['middleware' => 'role:merchant'], function () {});
});
