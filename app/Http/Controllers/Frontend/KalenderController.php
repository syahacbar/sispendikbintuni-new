<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExtKalender;
use App\Models\SysSetting;

class KalenderController extends Controller
{

    public function index()
    {

        $title = 'Kalender Pendidikan';
        $subtitle = 'Informasi jadwal penting sepanjang tahun ajaran.';

        $events = ExtKalender::all()->map(function ($event) {
            return [
                'title' => $event->nama,
                'start' => $event->tanggal_mulai,
                'end' => $event->tanggal_akhir,
                'color' => $event->tanggal_mulai === $event->tanggal_akhir ? '#28a745' : '#ffc107',
                'description' => $event->deskripsi,
                'waktu' => $event->waktu,
                'jam_mulai' => $event->jam_mulai,
                'jam_akhir' => $event->jam_akhir,
            ];
        });

        return view('frontend.pages.kalender', compact(
            'title',
            'subtitle',
            'events'
        ));
    }
}
