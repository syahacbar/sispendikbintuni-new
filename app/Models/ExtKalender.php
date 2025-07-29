<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ExtKalender extends Model
{
    use HasUuids;

    protected $table = 'ext_kalender';

    protected $fillable = [
        'id',
        'nama',
        'tanggal_mulai',
        'tanggal_akhir',
        'waktu',
        'jam_mulai',
        'jam_akhir',
        'deskripsi',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class);
    }
}
