<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DirektoriController;

Route::get('/direktori', [DirektoriController::class, 'index']);
