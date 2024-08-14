<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\App\Http\Controllers\TestController::class, 'test'])->name('api.test');

/**
 *
 *
 * Auth
 *
 *
 */
Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->middleware(['guest']);
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->middleware(['auth:sanctum']);

    Route::group([
        'prefix' => 'verification'
    ], function () {

        Route::post('/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'verify']);
        Route::post('/resend', [\App\Http\Controllers\Auth\VerificationController::class, 'resend']);

    });

    Route::group([
        'prefix' => 'password'
    ], function () {

        Route::post('/send-link', [\App\Http\Controllers\Auth\PasswordController::class, 'sendLink']);
        Route::post('/reset', [\App\Http\Controllers\Auth\PasswordController::class, 'reset']);

    });

});

/**
 *
 *
 * Me
 *
 *
 */
Route::group([
    'prefix' => 'me',
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('/', [\App\Http\Controllers\MeController::class, 'me']);
    Route::put('/', [\App\Http\Controllers\MeController::class, 'update']);
    Route::delete('/', [\App\Http\Controllers\MeController::class, 'delete']);

    Route::group([
        'prefix' => 'avatar'
    ], function () {

        Route::post('/', [\App\Http\Controllers\MeController::class, 'avatarUpload']);
        Route::delete('/', [\App\Http\Controllers\MeController::class, 'avatarDelete']);

    });

});

/**
 *
 *
 * Admin
 *
 *
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('/test', [\App\Http\Controllers\Admin\TestController::class, 'test']);

    Route::group([
        'prefix' => 'users'
    ], function () {

        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store']);
        Route::get('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show']);
        Route::put('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update']);
        Route::delete('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy']);

        Route::get('/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'roles']);
        Route::patch('/{user}/roles/{role}/assign', [\App\Http\Controllers\Admin\UserController::class, 'assignRole']);
        Route::patch('/{user}/roles/{role}/remove', [\App\Http\Controllers\Admin\UserController::class, 'removeRole']);

    });

    Route::group([
        'prefix' => 'roles'
    ], function () {

        Route::get('/', [\App\Http\Controllers\Admin\RoleController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\RoleController::class, 'store']);
        Route::get('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'show']);
        Route::delete('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy']);

        Route::patch('/{role}/permissions/give', [\App\Http\Controllers\Admin\RoleController::class, 'givePermissions']);
        Route::patch('/{role}/permissions/revoke', [\App\Http\Controllers\Admin\RoleController::class, 'revokePermissions']);

    });

});
