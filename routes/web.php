<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// FrontEnd
Route::get('/', function () {
    return view('frontend.pages.home');
});

Route::get('/sekolah', [SekolahController::class, 'index']);
Route::get('/sekolah/{slug}', [SekolahController::class, 'show'])->name('frontend.sekolah.show');

Route::get('/ptk', [PTKController::class, 'index']);
Route::get('/siswa', [SiswaController::class, 'index']);


Route::get('/sebaran', function () {
    return view('frontend.pages.sebaran');
});


Route::get('/kalender', function () {
    return view('frontend.pages.kalender');
});
Route::get('/informasi', function () {
    return view('frontend.pages.informasi');
});
Route::get('/pengaduan', function () {
    return view('frontend.pages.pengaduan');
});
