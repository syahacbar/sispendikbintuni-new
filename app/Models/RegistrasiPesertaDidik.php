<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RegistrasiPesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'tbl_registrasi_peserta_didiks';
    protected $fillable = ['peserta_didik_id', 'tahun_ajaran', 'tanggal_registrasi', 'asal_sekolah'];

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }
}
