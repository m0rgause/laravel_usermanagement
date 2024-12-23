<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthGuard;
use App\Http\Middleware\IsLoggedIn;

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

Route::middleware([AuthGuard::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware([IsLoggedIn::class])->group(function () {
    Route::prefix('signin')->group(function () {
        Route::get('/', [AuthController::class, 'login'])->name('signin');
        Route::post('/', [AuthController::class, 'loginProcess'])->name('signin.process');
    });
});
Route::get('signout', [AuthController::class, 'logout'])->name('signout');
