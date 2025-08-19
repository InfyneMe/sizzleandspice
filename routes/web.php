<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenueController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('loginUser', [AuthController::class, 'login'])->name('loginUser');

Route::middleware('check.auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('menu', [MenueController::class, 'index'])->name('menu');
    Route::get('menu/create', [MenueController::class, 'create'])->name('menu.create');
    Route::post('menu/store', [MenueController::class, 'store'])->name('menu.store');
});
