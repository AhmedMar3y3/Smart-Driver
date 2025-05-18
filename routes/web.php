<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Client\PaymentController;
use App\Http\Controllers\API\Client\QuestionPaymentController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscription/payment/callback', [PaymentController::class, 'callback'])->name('subscription.payment.callback');
Route::get('/subscription/payment/error',    [PaymentController::class, 'error'])->name('subscription.payment.error');

Route::get('/question/payment/callback', [QuestionPaymentController::class, 'callback'])->name('question.payment.callback');
Route::get('/question/payment/error', [QuestionPaymentController::class, 'error'])->name('question.payment.error');