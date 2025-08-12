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

    public function wilayah()
    {
        return $this->belongsTo(RefWilayah::class, 'kode_wilayah', 'kode');
    }

    public function anggotaRombel()
    {
        return $this->hasMany(MstAnggotaRombel::class, 'peserta_didik_id');
    }

    public function rombels()
    {
        return $this->belongsToMany(
            MstRombel::class,
            'mst_anggota_rombel',
            'peserta_didik_id',
            'rombel_id'
        );
    }
}
