<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstPesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'mst_peserta_didik';

    protected $fillable = [
        'nama',
        'nisn',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kode_wilayah',
        'kode_pos',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'id_sekolah');
    }
}
