<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Berikut adalah daftar rute aplikasi web yang mencakup login, registrasi,
| manajemen produk, dan dashboard. Rute dilindungi oleh middleware 'auth'
| jika membutuhkan autentikasi.
*/

// Rute untuk Login dan Registrasi
Route::get('/', [UserController::class, 'login'])->name('login'); // Halaman login
Route::get('/register', [UserController::class, 'register'])->name('register'); // Halaman registrasi
Route::post('/register', [UserController::class, 'registerStore'])->name('register.store'); // Proses registrasi
Route::post('/login', [UserController::class, 'loginCheck'])->name('login.check'); // Proses login
Route::post('/logout', [UserController::class, 'logout'])->name('logout'); // Proses logout (gunakan POST)

// Rute dengan middleware autentikasi
Route::middleware(['auth'])->group(function() {
    // Dashboard
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    // Manajemen Produk
    Route::get('/produk/{id}/tambah-stok', [ProdukController::class, 'formTambahStok'])
        ->name('produk.formTambahStok'); // Form tambah stok produk
    Route::post('/produk/{id}/tambah-stok', [ProdukController::class, 'prosesTambahStok'])
        ->name('produk.prosesTambahStok'); // Proses tambah stok produk
    Route::resource('produk', ProdukController::class); // CRUD lengkap untuk produk
});
