<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MataPelajaran extends Model
{
    use HasUuids;

    protected $table = 'tbl_mata_pelajarans';
    protected $fillable = ['kode_mapel', 'nama', 'kelompok', 'jenjang', 'kurikulum_id', 'is_praktik'];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    public function rombelMapels()
    {
        return $this->hasMany(RombelMapel::class);
    }
}
