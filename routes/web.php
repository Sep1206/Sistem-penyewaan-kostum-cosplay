<?php

use App\Http\Controllers\AccessoriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MyRentalController;
use App\Http\Controllers\RentalScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('costumes.index'));

// Login & registrasi (hanya untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ADMIN: BREAD penuh. Didaftarkan lebih dulu agar /costumes/create
// tidak tertangkap oleh /costumes/{costume}.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('costumes', CostumeController::class)->except(['index', 'show']);
    Route::resource('accessories', AccessoriesController::class)->except(['index', 'show']);
    Route::resource('customers', CustomerController::class);
    Route::resource('rental_schedules', RentalScheduleController::class);
});

// ADMIN & CUSTOMER: lihat katalog + customer memesan sendiri
Route::middleware('auth')->group(function () {
    Route::resource('costumes', CostumeController::class)->only(['index', 'show']);
    Route::resource('accessories', AccessoriesController::class)->only(['index', 'show']);

    Route::get('/pesanan-saya', [MyRentalController::class, 'index'])->name('my_rentals.index');
    Route::get('/pesanan-saya/buat', [MyRentalController::class, 'create'])->name('my_rentals.create');
    Route::post('/pesanan-saya', [MyRentalController::class, 'store'])->name('my_rentals.store');
});
