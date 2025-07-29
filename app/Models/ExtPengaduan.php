<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ExtPengaduan extends Model
{
    use HasUuids;
    protected $table = 'ext_pengaduan';
    protected $fillable = [
        'nomor_laporan',
        'nama_pelapor',
        'judul_laporan',
        'email',
        'no_hp',
        'kategori',
        'dok_lampiran',
        'isi',
        'status',
        'ip_address',
    ];
}
