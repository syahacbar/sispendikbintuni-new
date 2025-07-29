<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstAnggotaRombel extends Model
{
    use HasUuids;

    protected $table = 'mst_anggota_rombel';
    protected $fillable = [
        'rombel_id',
        'peserta_didik_id',
        'status_keaktifan',
        'tanggal_masuk',
        'tanggal_keluar',
        'keterangan',
    ];

    // public function rombonganBelajar()
    // {
    //     return $this->belongsTo(MstRombel::class);
    // }

    public function rombel()
    {
        return $this->belongsTo(MstRombel::class, 'rombel_id');
    }

    public function pesertaDidik()
    {
        return $this->belongsTo(MstPesertaDidik::class, 'peserta_didik_id');
    }
}
