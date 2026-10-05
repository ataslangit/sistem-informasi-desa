<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\LetterRequestController;
use App\Http\Controllers\Admin\LetterTemplateController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PopulationReportController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ResidentMutationController;
use App\Http\Controllers\Admin\ThemeSettingController as AdminThemeSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Citizen\CitizenLetterController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LetterVerificationController;
use App\Http\Controllers\Public\PageController as PublicPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiDesa (Sistem Informasi Desa)
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Portal Desa, Berita CMS, Halaman Profil & Verifikasi Dokumen) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PublicArticleController::class, 'index'])->name('articles.index');
Route::get('/berita/{slug}', [PublicArticleController::class, 'show'])->name('articles.show');
Route::get('/kategori/{slug}', [PublicArticleController::class, 'category'])->name('articles.category');
Route::get('/halaman/{slug}', [PublicPageController::class, 'show'])->name('pages.show');
Route::get('/verify/letter/{qrToken}', [LetterVerificationController::class, 'verify'])->name('verify.letter');

// --- Rute Otentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// --- Rute Layanan Mandiri Warga ---
Route::prefix('citizen')
    ->name('citizen.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/letters', [CitizenLetterController::class, 'index'])->name('letters.index');
        Route::get('/letters/create', [CitizenLetterController::class, 'create'])->name('letters.create');
        Route::post('/letters', [CitizenLetterController::class, 'store'])->name('letters.store');
        Route::get('/letters/{letterRequest}', [CitizenLetterController::class, 'show'])->name('letters.show');
        Route::get('/letters/{letterRequest}/pdf', [CitizenLetterController::class, 'downloadPdf'])->name('letters.pdf');
    });

// --- Rute Khusus Admin / Aparatur Desa / RT ---
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

        // Layanan E-Surat Desa
        Route::get('/letter-templates/{letterTemplate}/preview', [LetterTemplateController::class, 'preview'])->name('letter-templates.preview');
        Route::resource('letter-templates', LetterTemplateController::class);
        Route::get('/letter-requests', [LetterRequestController::class, 'index'])->name('letter-requests.index');
        Route::get('/letter-requests/{letterRequest}', [LetterRequestController::class, 'show'])->name('letter-requests.show');
        Route::post('/letter-requests/{letterRequest}/verify-rt', [LetterRequestController::class, 'verifyRt'])->name('letter-requests.verify-rt');
        Route::post('/letter-requests/{letterRequest}/bypass-rt', [LetterRequestController::class, 'bypassRt'])->name('letter-requests.bypass-rt');
        Route::post('/letter-requests/{letterRequest}/verify-staff', [LetterRequestController::class, 'verifyStaff'])->name('letter-requests.verify-staff');
        Route::post('/letter-requests/{letterRequest}/approve-kades', [LetterRequestController::class, 'approveKades'])->name('letter-requests.approve-kades');
        Route::post('/letter-requests/{letterRequest}/reject', [LetterRequestController::class, 'reject'])->name('letter-requests.reject');
        Route::get('/letter-requests/{letterRequest}/pdf', [LetterRequestController::class, 'downloadPdf'])->name('letter-requests.pdf');

        // Audit Trail System (Audit Engine)
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');

        // CMS & Portal Publik (Berita, Kategori, Halaman Statis & Tema)
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::get('/themes', [AdminThemeSettingController::class, 'index'])->name('themes.index');
        Route::post('/themes', [AdminThemeSettingController::class, 'update'])->name('themes.update');
    });
