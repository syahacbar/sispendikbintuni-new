<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kurikulum extends Model
{
    use HasUuids;

    protected $table = 'tbl_kurikulums';
    protected $fillable = ['kode', 'nama', 'jenis', 'tahun_mulai', 'status'];

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class);
    }
    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
}
