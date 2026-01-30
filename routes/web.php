<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\Frontend\SebaranController;
use App\Http\Controllers\Frontend\SekolahController;
use App\Http\Controllers\Frontend\TentangController;
use App\Http\Controllers\Frontend\KalenderController;
use App\Http\Controllers\Frontend\InformasiController;
use App\Http\Controllers\Frontend\PengaduanController;
use App\Http\Controllers\Frontend\DataPendidikanController;

// Rute FrontEnd
Route::get('/', [BerandaController::class, 'index']);
Route::get('/sekolah', [SekolahController::class, 'index']);
Route::get('/sekolah/{slug}', [SekolahController::class, 'show'])->name('frontend.sekolah.show');
Route::get('/informasi/berita', [InformasiController::class, 'berita']);
Route::get('/informasi/berita/{slug}', [InformasiController::class, 'show_berita'])->name('frontend.berita.show_berita');
Route::get('/informasi/pengumuman', [InformasiController::class, 'pengumuman']);
Route::get('/informasi/pengumuman/{slug}', [InformasiController::class, 'show_pengumuman'])->name('frontend.pengumuman.show_pengumuman');
Route::get('/informasi/kegiatan', [InformasiController::class, 'kegiatan']);
Route::get('/informasi/kegiatan/{slug}', [InformasiController::class, 'show_kegiatan'])->name('frontend.kegiatan.show_kegiatan');
Route::get('/get-kegiatan-by-date', [InformasiController::class, 'getByDate']);
// Route::get('/siswa', [SiswaController::class, 'index']); // TODO: Create SiswaController
Route::get('/peta-sebaran', [SebaranController::class, 'index']);
Route::get('/kalender-pendidikan', [KalenderController::class, 'index']);
Route::get('/buat-pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/tentang', [TentangController::class, 'index']);
Route::get('/data-pendidikan', [DataPendidikanController::class, 'index'])->name('pendidikan.index');
Route::get('/data-pendidikan/kecamatan/{kecamatan}/sekolah', [DataPendidikanController::class, 'sekolahByKecamatan'])
    ->where('kecamatan', '.*')->name('pendidikan.sekolahByKecamatan');
Route::get('/data-pendidikan/sekolah/{npsn}', [DataPendidikanController::class, 'detail'])
    ->name('pendidikan.sekolah.detail');

// Tailwind Demo Route
Route::get('/tailwind-demo', function () {
    return view('tailwind_demo');
});


// Google OAuth Routes
Route::get('/paneladmin/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('/paneladmin/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

// School Selection for Google OAuth Users
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/paneladmin/auth/select-school', \App\Filament\Paneladmin\Pages\Auth\SelectSchool::class)
        ->name('auth.select-school');
});

// Route to take impersonation (for opening in new tab)
Route::get('filament-impersonate/take/{id}', function ($id) {
    $user = auth()->user();
    $targetUser = \App\Models\User::findOrFail($id);

    if (!$user || !$user->canImpersonate() || !$targetUser->canBeImpersonated()) {
        abort(403);
    }

    session()->put('impersonate.back_to', \App\Filament\Resources\MstSekolahResource::getUrl());

    app(\Lab404\Impersonate\Services\ImpersonateManager::class)->take($user, $targetUser);

    return redirect(filament()->getPanel('admin')->getUrl());
})->name('filament-impersonate.take')->middleware(['web', 'auth']);

// Fix Filament Impersonate Leave Route
Route::get('filament-impersonate/leave', function () {
    if (!app(\Lab404\Impersonate\Services\ImpersonateManager::class)->isImpersonating()) {
        return redirect('/');
    }

    app(\Lab404\Impersonate\Services\ImpersonateManager::class)->leave();

    $backTo = session()->pull('impersonate.back_to');

    // Default to Data Sekolah if session missing
    $fallbackUrl = class_exists(\App\Filament\Resources\MstSekolahResource::class)
        ? \App\Filament\Resources\MstSekolahResource::getUrl()
        : filament()->getPanel('paneladmin')->getUrl();

    return redirect($backTo ?? $fallbackUrl);
})->name('filament-impersonate.leave')->middleware(config('filament-impersonate.leave_middleware', 'web'));
