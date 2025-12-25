<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment', function () {
    return view('payment.form');
})->name('payment.form');

Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');

// ここを修正：GETとPOSTの両方に対応
Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
