<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\SekolahController;
use App\Http\Controllers\Api\PetaSebaranController;

Route::get('/distriklist', [WilayahController::class, 'distrikList']);
Route::get('/sekolah/by-distrik/{kode_wilayah}', [SekolahController::class, 'byDistrik']);
Route::get('sekolah/detail/{id}', [SekolahController::class, 'detail']);
Route::get('/sebaran', [PetaSebaranController::class, 'index']);
