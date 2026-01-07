<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;



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



// 領収書ダウンロード
Route::get('/payment/receipt/download', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt.download');



Route::get('/invoice', [InvoiceController::class, 'form'])->name('invoice.form');
Route::post('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::get('/invoice/list', [InvoiceController::class, 'index'])->name('invoice.index');
Route::match(['get', 'post'], '/invoice/webhook', [InvoiceController::class, 'webhook'])->name('invoice.webhook');
Route::match(['get', 'post'], '/payment/failed', [PaymentController::class, 'failed'])
    ->name('payment.failed');
