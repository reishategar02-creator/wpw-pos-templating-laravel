<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // Pengalih umum (dipakai Breeze: register, /profile) -> arahkan sesuai role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('kasir.dashboard');
    })->name('dashboard');

    // --- AREA KHUSUS ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('products', ProductController::class);
    });

    // --- AREA KHUSUS KASIR ---
    Route::middleware('role:kasir')->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'index'])
            ->name('kasir.dashboard');

        Route::get('/kasir/transaksi/cari', [KasirController::class, 'search'])
            ->name('kasir.transaksi.cari');

        Route::post('/kasir/transaksi', [KasirController::class, 'store'])
            ->name('kasir.transaksi.store');

        Route::get('/kasir/transaksi/{transaction}/struk', [KasirController::class, 'struk'])
            ->name('kasir.transaksi.struk');
    });

    // Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});