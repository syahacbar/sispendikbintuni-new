<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'tbl_peserta_didiks';

    protected $fillable = [
        'sekolah_id',
        'nama',
        'nisn',
        'nik',
        'jenis_kelamin',
        'tgl_lahir',
        'rombongan_belajar_id',
        'alamat_jalan',
        'desa_kelurahan',
        'kode_pos',
        'kecamatan',
        'kabupaten',
        'provinsi',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function anggotaRombels()
    {
        return $this->hasMany(AnggotaRombel::class);
    }

    public function registrasi()
    {
        return $this->hasOne(RegistrasiPesertaDidik::class);
    }

    public function rombongan_belajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
    }
}
