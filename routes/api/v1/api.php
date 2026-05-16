<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Middleware\RefreshTokenMiddleware;

Route::prefix('v1')->as('v1.')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify-otp');
        Route::patch('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
        Route::get('/refresh-token', [AuthController::class, 'refreshToken'])->name('refresh-token')
            ->middleware(RefreshTokenMiddleware::class);

        Route::middleware('auth:api')->group(function () {
            Route::get('/me', [AuthController::class, 'me'])->name('me');
            Route::post('/logout', [AuthController::class, 'logOut'])->name('logout');
            Route::patch('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('branches', BranchController::class);
    });
});
