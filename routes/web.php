<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); // ✅ pastikan file ini ada
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
// LOGIN ADMIN
Route::get('/login-admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin.process');

// LOGIN SISWA
Route::get('/login-siswa', [AuthController::class, 'showSiswaLogin'])->name('login.siswa');
Route::post('/login-siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa.process');

// DEFAULT LOGIN (optional)
Route::get('/login', fn() => redirect()->route('login.siswa'))->name('login');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| BOOK
|--------------------------------------------------------------------------
*/
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

// SISWA BOOK
Route::get('/siswa/books', [BookController::class, 'indexSiswa'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| TRANSAKSI
|--------------------------------------------------------------------------
*/
// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'indexAdmin']);
});

// SISWA
Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/transaksi', [TransactionController::class, 'indexSiswa']);
});

// PINJAM & KEMBALIKAN
Route::post('/transactions/pinjam', [TransactionController::class, 'pinjam']);
Route::post('/transactions/kembalikan/{id}', [TransactionController::class, 'kembalikan']);

/*
|--------------------------------------------------------------------------
| MEMBER
|--------------------------------------------------------------------------
*/
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);
Route::post('/members/toggle/{id}', [MemberController::class, 'toggle']);


// REGISTER SISWA
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/buku-saya', [TransactionController::class, 'bukuSaya']);
    Route::get('/siswa/riwayat', [TransactionController::class, 'riwayat']);
});
