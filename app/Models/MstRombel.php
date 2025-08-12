<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function pesertaDidiks(): HasMany
    {
        return $this->hasMany(MstAnggotaRombel::class, 'rombel_id')
            ->join('mst_peserta_didik', 'mst_anggota_rombel.peserta_didik_id', '=', 'mst_peserta_didik.id')
            ->select('mst_peserta_didik.*');
    }

    public function kurikulum()
    {
        return $this->belongsTo(RefKurikulum::class, 'kurikulum_id', 'id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(MstGtk::class, 'wali_kelas_ptk_id', 'id');
    }

    public function anggotaRombels()
    {
        return $this->hasMany(MstAnggotaRombel::class, 'rombel_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(RefSemester::class, 'semester_id');
    }
}
