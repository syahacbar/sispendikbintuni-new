<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pengaduan extends Model
{
    use HasUuids;
    protected $table = 'tbl_pengaduans';
    protected $fillable = [
        'nomor_laporan',
        'judul_laporan',
        'nama_pelapor',
        'email',
        'no_hp',
        'kategori',
        'dok_lampiran',
        'isi',
        'status',
    ];
}
