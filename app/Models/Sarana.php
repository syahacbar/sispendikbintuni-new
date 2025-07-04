<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sarana extends Model
{
    use HasUuids;

    protected $table = 'tbl_saranas';

    protected $fillable = [
        'sekolah_id',
        'r_kelas',
        'r_perpus',
        'r_lab',
        'r_praktik',
        'r_pimpinan',
        'r_guru',
        'r_ibadah',
        'r_uks',
        'r_toilet',
        'r_gudang',
        'r_sirkulasi',
        'tempat_bermain',
        'r_tu',
        'r_konseling',
        'r_osis',
        'r_bangunan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
