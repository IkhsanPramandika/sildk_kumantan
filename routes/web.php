<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\VillageHistoryController;
use App\Http\Controllers\Admin\VillageProfileController;
use App\Http\Controllers\Admin\VillagePotentialController;


// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1') // 5 attempts per minute
        ->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// CKEditor Upload
Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Residents
    Route::post('/residents/import', [\App\Http\Controllers\Admin\ResidentController::class, 'import'])->name('residents.import');
    Route::get('residents', [\App\Http\Controllers\Admin\ResidentController::class, 'index'])->name('residents.index');
    Route::get('residents/create', [\App\Http\Controllers\Admin\ResidentController::class, 'create'])->name('residents.create');
    Route::post('residents', [\App\Http\Controllers\Admin\ResidentController::class, 'store'])->name('residents.store');
    Route::get('residents/{resident}', [\App\Http\Controllers\Admin\ResidentController::class, 'show'])->name('residents.show');
    Route::get('residents/{resident}/edit', [\App\Http\Controllers\Admin\ResidentController::class, 'edit'])->name('residents.edit');
    Route::post('residents/{resident}', [\App\Http\Controllers\Admin\ResidentController::class, 'update'])->name('residents.update');
    Route::delete('residents/{resident}', [\App\Http\Controllers\Admin\ResidentController::class, 'destroy'])->name('residents.destroy');

    // Village Potentials
    Route::get('village-potentials', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'index'])->name('village-potentials.index');
    Route::get('village-potentials/create', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'create'])->name('village-potentials.create');
    Route::post('village-potentials', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'store'])->name('village-potentials.store');
    Route::get('village-potentials/{villagePotential}', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'show'])->name('village-potentials.show');
    Route::get('village-potentials/{villagePotential}/edit', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'edit'])->name('village-potentials.edit');
    Route::post('village-potentials/{villagePotential}', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'update'])->name('village-potentials.update');
    Route::delete('village-potentials/{villagePotential}', [\App\Http\Controllers\Admin\VillagePotentialController::class, 'destroy'])->name('village-potentials.destroy');

    // Products
    Route::get('products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
    Route::get('products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // News
    Route::get('news', [\App\Http\Controllers\Admin\NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [\App\Http\Controllers\Admin\NewsController::class, 'create'])->name('news.create');
    Route::post('news', [\App\Http\Controllers\Admin\NewsController::class, 'store'])->name('news.store');
    Route::get('news/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'show'])->name('news.show');
    Route::get('news/{news}/edit', [\App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('news.edit');
    Route::post('news/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'update'])->name('news.update');
    Route::delete('news/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('news.destroy');

    // Events
    Route::get('events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
    Route::get('events/create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('events.create');
    Route::post('events', [\App\Http\Controllers\Admin\EventController::class, 'store'])->name('events.store');
    Route::get('events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'show'])->name('events.show');
    Route::get('events/{event}/edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('events.edit');
    Route::post('events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('events.destroy');

    // Galleries
    Route::get('galleries', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('galleries.index');
    Route::get('galleries/create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('galleries.create');
    Route::post('galleries', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('galleries.store');
    Route::get('galleries/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('galleries.show');
    Route::get('galleries/{gallery}/edit', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('galleries.edit');
    Route::post('galleries/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('galleries/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('galleries.destroy');

    // Complaints
    Route::get('complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/create', [\App\Http\Controllers\Admin\ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('complaints/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('complaints/{complaint}/edit', [\App\Http\Controllers\Admin\ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::post('complaints/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'update'])->name('complaints.update');
    Route::post('complaints/{complaint}/respond', [\App\Http\Controllers\Admin\ComplaintController::class, 'respond'])->name('complaints.respond');
    Route::delete('complaints/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'destroy'])->name('complaints.destroy');

    // Village Profile and Organizations
    Route::get('/village-profile', [VillageProfileController::class, 'edit'])->name('village-profile.edit');
    Route::post('/village-profile', [VillageProfileController::class, 'update'])->name('village-profile.update');
    Route::get('/village-history', [VillageHistoryController::class, 'edit'])->name('village-history.edit');
    Route::post('/village-history', [VillageHistoryController::class, 'update'])->name('village-history.update');
    Route::get('/organizations/{type}', [\App\Http\Controllers\Admin\OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::post('/organizations/{type}', [\App\Http\Controllers\Admin\OrganizationController::class, 'update'])->name('organizations.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Guest Routes
Route::get('/', [\App\Http\Controllers\Guest\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profil-desa')->name('profile.')->group(function () {
    Route::get('/demografi', [\App\Http\Controllers\Guest\DemographicsController::class, 'index'])->name('demographics');
    Route::get('/sejarah-desa', [\App\Http\Controllers\Guest\OrganizationController::class, 'history'])->name('history');
    Route::get('/struktur-organisasi', [\App\Http\Controllers\Guest\OrganizationController::class, 'structure'])->name('structure');
});

// Potentials Routes
Route::prefix('potensi-desa')->name('potentials.')->group(function () {
    Route::get('/sumber-daya-alam', [\App\Http\Controllers\Guest\VillagePotentialController::class, 'naturalResources'])->name('natural-resources');
    Route::get('/infrastruktur', [\App\Http\Controllers\Guest\VillagePotentialController::class, 'infrastructure'])->name('infrastructure');
    Route::get('/umkm', [\App\Http\Controllers\Guest\ProductController::class, 'index'])->name('umkm');
    Route::get('/umkm/{product}', [\App\Http\Controllers\Guest\ProductController::class, 'show'])->name('umkm.show');
    Route::get('/{potential}', [\App\Http\Controllers\Guest\VillagePotentialController::class, 'show'])->name('show');
});

// Organization Routes
Route::prefix('kelembagaan')->name('organizations.')->group(function () {
    Route::get('/bpd', [\App\Http\Controllers\Guest\OrganizationController::class, 'bpd'])->name('bpd');
    Route::get('/karang-taruna', [\App\Http\Controllers\Guest\OrganizationController::class, 'karangTaruna'])->name('karang-taruna');
    Route::get('/pkk', [\App\Http\Controllers\Guest\OrganizationController::class, 'pkk'])->name('pkk');
});

// News Routes
Route::prefix('berita')->name('news.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Guest\NewsController::class, 'index'])->name('index');
    Route::get('/{news:slug}', [\App\Http\Controllers\Guest\NewsController::class, 'show'])->name('show');
});

// Event Routes
Route::prefix('kegiatan')->name('events.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Guest\EventController::class, 'index'])->name('index');
    Route::get('/active', [\App\Http\Controllers\Guest\EventController::class, 'getActiveEvents'])->name('active');
    Route::get('/{event:slug}', [\App\Http\Controllers\Guest\EventController::class, 'show'])->name('show');
});

// Gallery Routes
Route::prefix('galeri')->name('galleries.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Guest\GalleryController::class, 'index'])->name('index');
});

// Complaint Routes
Route::prefix('pengaduan')->name('complaints.')->group(function () {
    Route::get('/buat', [\App\Http\Controllers\Guest\ComplaintController::class, 'create'])->name('create');
    Route::post('/buat', [\App\Http\Controllers\Guest\ComplaintController::class, 'store'])->name('store');
    Route::get('/cek', [\App\Http\Controllers\Guest\ComplaintController::class, 'check'])->name('check');
    Route::post('/cek', [\App\Http\Controllers\Guest\ComplaintController::class, 'checkStatus'])->name('check.status');
    Route::get('/status/{complaint:tracking_number}', [\App\Http\Controllers\Guest\ComplaintController::class, 'show'])->name('show');
    Route::get('/sukses', [\App\Http\Controllers\Guest\ComplaintController::class, 'success'])->name('success');
});

// peta-wilayah
Route::get('/peta-wilayah', function () {
    return redirect('https://gis.dukcapil.kemendagri.go.id/peta');
})->name('village-map');

// Contact Route
Route::get('/kontak', [\App\Http\Controllers\Guest\ContactController::class, 'index'])->name('contact');
