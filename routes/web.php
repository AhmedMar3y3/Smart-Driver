<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Client\PaymentController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscription/payment/callback', [PaymentController::class, 'callback'])->name('subscription.payment.callback');
Route::get('/subscription/payment/error',    [PaymentController::class, 'error'])->name('subscription.payment.error');
