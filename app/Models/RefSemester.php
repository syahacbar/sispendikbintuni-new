<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefSemester extends Model
{
    use HasUuids;

    use HasUuids;

    protected $table = 'ref_semester';

    protected $fillable = [
        'kode_semester',
        'tahun_ajaran',
        'nama_semester',
        'is_aktif',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class);
    }
}
