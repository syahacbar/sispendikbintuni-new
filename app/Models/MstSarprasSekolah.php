<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstSarprasSekolah extends Model
{
    use HasUuids;

    protected $table = 'mst_sarpras_sekolah';

    protected $fillable = [
        'sekolah_id',
        'sarpras_id',
        'nama',
        'jumlah_saat_ini',
        'jumlah_ideal',
        'keterangan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class);
    }

    public function jenisSarpras()
    {
        return $this->belongsTo(RefSarpras::class, 'jenis_sarpras_id');
    }

    public function sarpras()
    {
        return $this->belongsTo(RefSarpras::class, 'sarpras_id');
    }
}
