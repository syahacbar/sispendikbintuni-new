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
        'nama',
        'email',
        'telepon',
        'kategori',
        'dok_lampiran',
        'isi',
        'status',
    ];
}
