<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\App\Http\Controllers\Api\TestController::class, 'test'])->name('api.test');

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->middleware(['guest']);
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware(['auth:sanctum']);

    Route::group([
        'prefix' => 'verification'
    ], function () {

        Route::post('/verify', [\App\Http\Controllers\Api\Auth\VerificationController::class, 'verify']);
        Route::post('/resend', [\App\Http\Controllers\Api\Auth\VerificationController::class, 'resend']);

    });

    Route::group([
        'prefix' => 'password'
    ], function () {

        Route::post('/send-link', [\App\Http\Controllers\Api\Auth\PasswordController::class, 'sendLink']);
        Route::post('/reset', [\App\Http\Controllers\Api\Auth\PasswordController::class, 'reset']);

    });

});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('/test', [\App\Http\Controllers\Api\Admin\TestController::class, 'test']);

    Route::group([
        'prefix' => 'users'
    ], function () {

        Route::get('/', [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Admin\UserController::class, 'store']);
        Route::get('/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
        Route::put('/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'update']);
        Route::delete('/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);

    });

});
