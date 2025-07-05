<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MataPelajaran extends Model
{
    use HasUuids;

    protected $table = 'tbl_mata_pelajarans';
    protected $fillable = [
        'sekolah_id',
        'kode_mapel',
        'kelompok_mapels_id',
        'nama_mapel',
        'kelompok',
        'jenjang',
        'kurikulum_id',
        'is_praktik'
    ];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    public function rombelMapels()
    {
        return $this->hasMany(RombelMapel::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelompokMapel()
    {
        return $this->belongsTo(KelompokMapel::class, 'kelompok_mapels_id');
    }
}
