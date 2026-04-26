<?php


use App\Http\Controllers\AuthController;

Route::middleware('auth:api')->prefix('v1')->as('v1.')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::withoutMiddleware('auth:api')->group(function () {
            Route::post('/login', [AuthController::class, 'login'])->name('login');
            Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
            Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify-otp');
            Route::patch('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
        });

        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logOut'])->name('logout');
        Route::patch('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });
});
