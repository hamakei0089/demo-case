<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ListController;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;

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

Fortify::verifyEmailView(function () {
    return view('auth.verify-email');
});


Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);

    Route::get('/attendance', [AttendanceController::class, 'index']);

    Route::post('/startwork', [StampController::class, 'startwork']);
    Route::post('/endwork', [StampController::class, 'endwork']);

    Route::post('/startrest', [StampController::class, 'startrest']);
    Route::post('/endrest', [StampController::class, 'endrest']);

    Route::get('/list', [ListController::class, 'index']);

    Route::get('/personal/{id}', [ListController::class, 'detail'])->name('personal.detail');

 Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});