<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sarpras extends Model
{
    use HasUuids;

    protected $table = 'tbl_sarpras';

    protected $fillable = [
        'sekolah_id',
        'jenis_sarpras_id',
        'kategori',
        'jumlah_ideal',
        'jumlah_saat_ini',
        'kondisi',
        'kurang_lebih',
        'keterangan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jenisSarpras()
    {
        return $this->belongsTo(JenisSarpras::class, 'jenis_sarpras_id');
    }
}
