<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mailable', function () {
    // $invoice = App\Models\Invoice::find(1);
    // return new App\Mail\InvoicePaid($invoice);

    // return new \App\Mail\Auth\EmailVerificationMail(\App\Models\User::find(2));
});
