<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('loginUser', [AuthController::class, 'login'])->name('loginUser');

Route::middleware('check.auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //menue
    Route::get('menu', [MenueController::class, 'index'])->name('menu');
    Route::get('menu/create', [MenueController::class, 'create'])->name('menu.create');
    Route::post('menu/store', [MenueController::class, 'store'])->name('menu.store');
    Route::get('menu/edit/{id}', [MenueController::class, 'edit'])->name('menu.edit');
    Route::delete('/menu/{id}', [MenueController::class, 'destroy'])->name('menu.destroy');

    //table routes
    Route::get('table', [TableController::class, 'index'])->name('table');
    Route::get('table/create', [TableController::class, 'tableCreate'])->name('table.create');
    Route::post('tables/store', [TableController::class, 'store'])->name('tables.store');

    //order routes
    Route::get('order', [OrderController::class, 'orders'])->name('order');
    Route::post('queue/order', [OrderController::class, 'store'])->name('queue.order');

    Route::get('current/orders', [OrderController::class, 'currentOrders'])->name('current.orders');
    Route::get('order/details/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
    Route::post('/orders/{order}/update-items', [OrderController::class, 'updateItems'])->name('orders.updateItems');
    Route::post("/orders/payment/{id}", [OrderController::class, 'updatePayment'])->name('order.payment.edit');
    Route::get('order/history', [OrderController::class, 'orderHistory'])->name('order.history');



    
});
