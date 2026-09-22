<?php

use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerChatController;
use App\Http\Controllers\CustomerNotificationController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Halaman pertama: landing bakery
Route::get('/', [PageController::class, 'landing'])->name('home');

// Website/menu bakery (alias dari '/')
Route::get('/menu', [PageController::class, 'index'])->name('menu');

Route::post('/ai/chat', [AiChatController::class, 'chat'])
    ->middleware('throttle:10,1')
    ->name('ai.chat');

// Autentikasi tunggal (username + password) untuk semua role
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:10,1')
    ->name('login.submit');
Route::get('/customer/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/customer/register', [AuthController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Ruang pelanggan (harus login dengan role customer)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/customer/orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/customer/orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::get('/customer/orders/{order}/json', [CustomerOrderController::class, 'json'])->name('customer.orders.json');

    Route::get('/customer/notifications', [CustomerNotificationController::class, 'index'])->name('customer.notifications');
    Route::get('/customer/notifications/list', [CustomerNotificationController::class, 'list'])->name('customer.notifications.list');
    Route::post('/customer/notifications/read', [CustomerNotificationController::class, 'markAsRead'])->name('customer.notifications.read');
    Route::post('/customer/notifications/read/{notificationId}', [CustomerNotificationController::class, 'markAsRead'])->name('customer.notifications.readOne');

    Route::get('/customer/chat', [CustomerChatController::class, 'index'])->name('customer.chat');
    Route::post('/customer/chat/send', [CustomerChatController::class, 'send'])->name('customer.chat.send');
    Route::get('/customer/chat/poll', [CustomerChatController::class, 'poll'])->name('customer.chat.poll');
});

// Pemesanan pelanggan (wajib login customer agar nomor urut & riwayat tercatat)
Route::post('/orders', [OrderController::class, 'store'])
    ->middleware(['auth', 'customer', 'throttle:10,1'])
    ->name('orders.store');

// Ruang admin (harus login dengan role admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat');
    Route::get('/chat/overview', [AdminChatController::class, 'overview'])->name('chat.overview');
    Route::get('/chat/{chat}/messages', [AdminChatController::class, 'messages'])->name('chat.messages');
    Route::post('/chat/{chat}/send', [AdminChatController::class, 'send'])->name('chat.send');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/list', [AdminNotificationController::class, 'list'])->name('notifications.list');
    Route::post('/notifications/read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read/{notificationId}', [AdminNotificationController::class, 'markAsRead'])->name('notifications.readOne');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
});
