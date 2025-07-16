<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\PTKController;
// use App\Http\Controllers\Api\DirektoriController;
use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\Frontend\SiswaController;
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
Route::get('/siswa', [SiswaController::class, 'index']);
Route::get('/peta-sebaran', [SebaranController::class, 'index']);
Route::get('/kalender-pendidikan', [KalenderController::class, 'index']);
Route::get('/buat-pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/tentang', [TentangController::class, 'index']);
Route::get('/data-pendidikan', [DataPendidikanController::class, 'index'])->name('pendidikan.index');
Route::get('/data-pendidikan/kecamatan/{kecamatan}/sekolah', [DataPendidikanController::class, 'sekolahByKecamatan'])
    ->where('kecamatan', '.*')->name('pendidikan.sekolahByKecamatan');
Route::get('/data-pendidikan/sekolah/{slug}', [DataPendidikanController::class, 'detail'])
    ->name('pendidikan.sekolah.detail');


// Route::get('/direktori', [DirektoriController::class, 'index']);
