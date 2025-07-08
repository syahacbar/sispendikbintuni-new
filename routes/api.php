<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\DirektoriController;

Route::get('/direktori/distrik', [DirektoriController::class, 'distrik']);
Route::get('/distrik', [WilayahController::class, 'getDistrikWithSchoolCounts']);
