<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BudgetController as AdminBudgetController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\LetterRequestController;
use App\Http\Controllers\Admin\LetterTemplateController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PopulationReportController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ResidentMutationController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\ThemeSettingController as AdminThemeSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VillageBoundaryController as AdminVillageBoundaryController;
use App\Http\Controllers\Admin\VillageFacilityController as AdminVillageFacilityController;
use App\Http\Controllers\Auth\CitizenRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Citizen\CitizenLetterController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;
use App\Http\Controllers\Public\BudgetController as PublicBudgetController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LetterVerificationController;
use App\Http\Controllers\Public\MapController as PublicMapController;
use App\Http\Controllers\Public\PageController as PublicPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SiDesa (Sistem Informasi Desa)
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Portal Desa, Berita CMS, Halaman Profil, Galeri & Verifikasi Dokumen) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PublicArticleController::class, 'index'])->name('articles.index');
Route::get('/berita/{slug}', [PublicArticleController::class, 'show'])->name('articles.show');
Route::get('/pengumuman', [PublicArticleController::class, 'announcements'])->name('articles.announcements');
Route::get('/kategori/{slug}', [PublicArticleController::class, 'category'])->name('articles.category');
Route::get('/halaman/{slug}', [PublicPageController::class, 'show'])->name('pages.show');
Route::get('/galeri', [PublicGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{slug}', [PublicGalleryController::class, 'show'])->name('galleries.show');
Route::get('/apbdes', [PublicBudgetController::class, 'index'])->name('budgets.index');
Route::get('/peta', [PublicMapController::class, 'index'])->name('map.index');
Route::get('/verify/letter/{qrToken}', [LetterVerificationController::class, 'verify'])->name('verify.letter');

// --- Rute Otentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [CitizenRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [CitizenRegisterController::class, 'register'])->name('register.post');
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
        Route::post('/residents/{resident}/create-account', [ResidentController::class, 'createAccount'])->name('residents.create-account');
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

        // CMS & Portal Publik (Berita, Kategori, Halaman Statis, Galeri, Menu & Tema)
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::resource('galleries', AdminGalleryController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::post('/galleries/{gallery}/photos', [AdminGalleryController::class, 'storePhoto'])->name('galleries.photos.store');
        Route::delete('/galleries/{gallery}/photos/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('galleries.photos.destroy');
        Route::resource('menus', AdminMenuController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/themes', [AdminThemeSettingController::class, 'index'])->name('themes.index');
        Route::post('/themes', [AdminThemeSettingController::class, 'update'])->name('themes.update');

        // Transparansi APBDes & Keuangan Desa
        Route::resource('budgets', AdminBudgetController::class);
        Route::post('/budgets/{budget}/items', [AdminBudgetController::class, 'storeItem'])->name('budgets.items.store');
        Route::put('/budgets/{budget}/items/{item}', [AdminBudgetController::class, 'updateItem'])->name('budgets.items.update');
        Route::delete('/budgets/{budget}/items/{item}', [AdminBudgetController::class, 'destroyItem'])->name('budgets.items.destroy');

        // Web GIS & Pemetaan Wilayah Desa
        Route::resource('boundaries', AdminVillageBoundaryController::class)->except(['create', 'show', 'edit']);
        Route::resource('facilities', AdminVillageFacilityController::class)->except(['create', 'show', 'edit']);

        // Konfigurasi Pengguna & Role (Khusus Superadmin)
        Route::middleware('role:superadmin')->group(function () {
            Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::resource('users', AdminUserController::class);
            Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');
            Route::get('/roles/{role}', [AdminRoleController::class, 'show'])->name('roles.show');
            Route::put('/roles/{role}/permissions', [AdminRoleController::class, 'updatePermissions'])->name('roles.permissions.update');
        });
    });
