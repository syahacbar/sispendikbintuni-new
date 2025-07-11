<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kalender extends Model
{
    use HasUuids;

    protected $table = 'tbl_kalenders';

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
        return $this->belongsTo(Sekolah::class);
    }
}
