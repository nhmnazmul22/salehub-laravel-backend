<?php


use App\Http\Controllers\AuthController;

Route::prefix('v1')->as('v1.')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

});
