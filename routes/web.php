<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Set\Access;
use App\Http\Controllers\Set\UserManagement;
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

    Route::get('setaccess', [Access::class, 'index'])->name('setaccess');
    Route::get('setaccess/new', [Access::class, 'create'])->name('setaccess.new');
    Route::post('setaccess/new', [Access::class, 'store'])->name('setaccess.store');
    Route::get('setaccess/{id}', [Access::class, 'edit'])->name('setaccess.edit');
    Route::put('setaccess/{id}', [Access::class, 'update'])->name('setaccess.update');
    Route::delete('setaccess/{id}', [Access::class, 'destroy'])->name('setaccess.destroy');

    Route::get('setusermanagement', [UserManagement::class, 'index'])->name('setusermanagement');
    Route::get('setusermanagement/new', [UserManagement::class, 'create'])->name('setusermanagement.new');
    Route::post('setusermanagement/new', [UserManagement::class, 'store'])->name('setusermanagement.store');
    Route::get('setusermanagement/{id}', [UserManagement::class, 'edit'])->name('setusermanagement.edit');
    Route::put('setusermanagement/{id}', [UserManagement::class, 'update'])->name('setusermanagement.update');
    Route::delete('setusermanagement/{id}', [UserManagement::class, 'destroy'])->name('setusermanagement.destroy');
    Route::get('setusermanagement/reset/{id}', [UserManagement::class, 'reset'])->name('setusermanagement.reset');
    Route::put('setusermanagement/reset/{id}', [UserManagement::class, 'resetProcess'])->name('setusermanagement.reset.process');
    Route::get('setusermanagement/apv/{id}', [UserManagement::class, 'approval'])->name('setusermanagement.apv');
    Route::put('setusermanagement/apv/{id}', [UserManagement::class, 'approvalProcess'])->name('setusermanagement.apv.process');
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
