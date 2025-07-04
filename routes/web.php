<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\SekolahController;
use App\Http\Controllers\Frontend\InformasiController;
use App\Http\Controllers\Frontend\PTKController;
use App\Http\Controllers\Frontend\SiswaController;
use App\Http\Controllers\Frontend\HomeController;


// Route::get('/', function () {
//     return view('welcome');
// });



// // FrontEnd
// Route::get('/', function () {
//     return view('frontend.pages.home');
// });

Route::get('/', [HomeController::class, 'index']);
// Route::get('/', [SekolahController::class, 'index']);

Route::get('/sekolah', [SekolahController::class, 'index']);
Route::get('/sekolah/{slug}', [SekolahController::class, 'show'])->name('frontend.sekolah.show');

Route::get('/informasi/berita', [InformasiController::class, 'berita']);
Route::get('/informasi/berita/{slug}', [InformasiController::class, 'show_berita'])->name('frontend.berita.show_berita');

Route::get('/informasi/pengumuman', [InformasiController::class, 'pengumuman']);
Route::get('/informasi/pengumuman/{slug}', [InformasiController::class, 'show_pengumuman'])->name('frontend.pengumuman.show_pengumuman');

Route::get('/informasi/kegiatan', [InformasiController::class, 'kegiatan']);
Route::get('/informasi/kegiatan/{slug}', [InformasiController::class, 'show_kegiatan'])->name('frontend.kegiatan.show_kegiatan');


Route::get('/get-kegiatan-by-date', [InformasiController::class, 'getByDate']);


Route::get('/ptk', [PTKController::class, 'index']);
Route::get('/siswa', [SiswaController::class, 'index']);


Route::get('/sebaran', function () {
    return view('frontend.pages.sebaran');
});


Route::get('/kalender', function () {
    return view('frontend.pages.kalender');
});

Route::get('/pengaduan', function () {
    return view('frontend.pages.pengaduan');
});
