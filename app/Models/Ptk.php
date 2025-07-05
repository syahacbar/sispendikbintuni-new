<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ptk extends Model
{
    use HasUuids;

    protected $table = 'tbl_ptks';
    protected $fillable = ['sekolah_id', 'nama', 'nuptk', 'nik', 'jenis_kelamin', 'tgl_lahir', 'status', 'jenjang'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function waliRombels()
    {
        return $this->hasMany(RombonganBelajar::class, 'wali_ptk_id');
    }
    public function rombelMapels()
    {
        return $this->hasMany(RombelMapel::class);
    }
}
