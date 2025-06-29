<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AnggotaRombel extends Model
{
    use HasUuids;

    protected $table = 'tbl_anggota_rombels';
    protected $fillable = ['rombongan_belajar_id', 'peserta_didik_id', 'jenis_pendaftaran', 'tanggal_masuk'];

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
    }
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }
}
