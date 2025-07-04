<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'tbl_peserta_didiks';
    protected $fillable = ['sekolah_id', 'nama', 'nisn', 'nik', 'jenis_kelamin', 'tgl_lahir'];

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
}
