<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\App\Http\Controllers\Api\Test::class, 'test'])->name('api.test');
