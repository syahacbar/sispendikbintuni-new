<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RombelMapel extends Model
{
    use HasUuids;

    protected $table = 'tbl_rombel_mapels';
    protected $fillable = ['rombongan_belajar_id', 'mata_pelajaran_id', 'ptk_id', 'jam_per_minggu'];

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
    }
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
    public function ptk()
    {
        return $this->belongsTo(Ptk::class);
    }
}
