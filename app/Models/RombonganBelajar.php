<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RombonganBelajar extends Model
{
    use HasUuids;

    protected $table = 'tbl_rombongan_belajars';
    protected $fillable = ['sekolah_id', 'wali_ptk_id', 'nama_rombel', 'tingkat_kelas', 'semester', 'kurikulum_id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function wali()
    {
        return $this->belongsTo(Ptk::class, 'wali_ptk_id');
    }
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    public function anggotaRombels()
    {
        return $this->hasMany(AnggotaRombel::class);
    }
    public function rombelMapels()
    {
        return $this->hasMany(RombelMapel::class);
    }
}
