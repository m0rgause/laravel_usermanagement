<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Set\Access;
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

    // Route::prefix('setaccess')->group(function () {
    //     Route::get('/', [Access::class, 'index'])->name('setaccess');
    //     Route::get('new', [Access::class, 'create'])->name('setaccess.new');
    // });

    Route::get('setaccess', [Access::class, 'index'])->name('setaccess');
    Route::get('setaccess/new', [Access::class, 'create'])->name('setaccess.new');
    Route::post('setaccess/new', [Access::class, 'store'])->name('setaccess.store');
    Route::get('setaccess/{id}', [Access::class, 'edit'])->name('setaccess.edit');
    Route::put('setaccess/{id}', [Access::class, 'update'])->name('setaccess.update');
    Route::delete('setaccess/{id}', [Access::class, 'destroy'])->name('setaccess.destroy');
});



Route::middleware([IsLoggedIn::class])->group(function () {
    Route::prefix('signin')->group(function () {
        Route::get('/', [AuthController::class, 'login'])->name('signin');
        Route::post('/', [AuthController::class, 'loginProcess'])->name('signin.process');
    });

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordProcess'])->name('forgot-password.process');

    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password/{token}', [AuthController::class, 'resetPasswordProcess'])->name('reset-password.process');
});
Route::get('signout', [AuthController::class, 'logout'])->name('signout');
