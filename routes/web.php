<?php

use App\Http\Controllers\FileController;  
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ImageController;

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
        Route::middleware('role:admin')->get('/laporan-pdf', [LaporanController::class, 'generatePDF'])
    ->name('laporan-pdf');

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

         Route::post('/upload', [FileController::class, 'upload'])
            ->name('file.upload');

        Route::get('/form-image', function () {
            return view('form-image'); 
        })->name('form-image');

        Route::post('/form-image', [ImageController::class, 'uploadAndResize'])
            ->name('image.upload');
    });

    // Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});