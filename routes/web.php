<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\PopulationReportController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ResidentMutationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiDesa (Sistem Informasi Desa)
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Portal Desa Tema Aktif) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Rute Otentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// --- Rute Khusus Admin / Aparatur Desa ---
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Kependudukan (Buku Induk)
        Route::resource('families', FamilyController::class);
        Route::resource('residents', ResidentController::class);

        // Mutasi Penduduk
        Route::get('/mutations', [ResidentMutationController::class, 'index'])->name('mutations.index');
        Route::get('/mutations/create', [ResidentMutationController::class, 'create'])->name('mutations.create');
        Route::post('/mutations', [ResidentMutationController::class, 'store'])->name('mutations.store');

        // Laporan & Statistik Kependudukan
        Route::get('/reports/population', [PopulationReportController::class, 'index'])->name('reports.population');
    });
