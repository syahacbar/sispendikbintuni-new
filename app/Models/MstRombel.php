<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstRombel extends Model
{
    use HasUuids;

    protected $table = 'mst_rombel';
    protected $fillable = [
        'sekolah_id',
        'kurikulum_id',
        'nama',
        'tingkat',
        'jurusan',
        'kapasitas',
        'wali_kelas_ptk_id',
        'semester_id',
        'status_aktif',
        'keterangan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'sekolah_id');
    }
}
