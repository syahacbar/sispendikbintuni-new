<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'mst_peserta_didik';

    protected $fillable = [
        'nama',
        'nisn',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kode_wilayah',
        'kode_pos',
    ];

    // public function sekolah()
    // {
    //     return $this->belongsTo(MstSekolah::class);
    // }

    // public function anggotaRombels()
    // {
    //     return $this->hasMany(AnggotaRombel::class);
    // }

    // public function registrasi()
    // {
    //     return $this->hasOne(RegistrasiPesertaDidik::class);
    // }

    // public function rombongan_belajar()
    // {
    //     return $this->belongsTo(RombonganBelajar::class);
    // }
}
