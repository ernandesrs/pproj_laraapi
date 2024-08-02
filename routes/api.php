<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\App\Http\Controllers\Api\Test::class, 'test'])->name('api.test');

Route::group([
    'prefix' => 'auth',
    'middleware' => 'guest'
], function () {

    Route::post('/login', [\App\Http\Controllers\Api\Auth\Login::class, 'attempt']);

});
