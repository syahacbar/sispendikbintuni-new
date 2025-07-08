<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirektoriController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'API Direktori OK'
        ]);
    }
}
