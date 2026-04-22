<?php


use App\Http\Controllers\AuthController;

Route::middleware('auth:api')->prefix('v1')->as('v1.')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login')
            ->withoutMiddleware('auth:api');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logOut'])->name('logout');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password')
            ->withoutMiddleware('auth:api');
    });
});
