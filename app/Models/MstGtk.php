<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstGtk extends Model
{
    use HasUuids;

    protected $table = 'mst_gtk';

    protected $fillable = [
        'nama',
        'nik',
        'nip',
        'nuptk',
        'tempat_lahir',
        'tempat_tugas',
        'tgl_lahir',
        'jenis_kelamin',
        'status_kepegawaian',
        'jenis_gtk',
        'pend_terakhir',
        'status_keaktifan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'sekolah_id');
    }

    public function rombels()
    {
        return $this->hasMany(MstRombel::class, 'wali_kelas_ptk_id', 'id');
    }

    public function sekolah_tempat_tugas()
    {
        return $this->belongsTo(MstSekolah::class, 'tempat_tugas', 'npsn');
    }
}
