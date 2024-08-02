<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\App\Http\Controllers\Api\TestController::class, 'test'])->name('api.test');

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->middleware(['guest']);
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware(['auth:sanctum']);

});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('/test', [\App\Http\Controllers\Api\Admin\TestController::class, 'test']);

});
