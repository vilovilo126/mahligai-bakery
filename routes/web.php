<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::post('/ai/chat', [AiChatController::class, 'chat'])
    ->middleware('throttle:10,1')
    ->name('ai.chat');

// Pemesanan pelanggan (tanpa login)
Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('orders.store');

// Halaman admin sederhana (daftar & detail pesanan)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});
