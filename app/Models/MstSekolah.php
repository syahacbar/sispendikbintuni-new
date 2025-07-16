<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class MstSekolah extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'mst_sekolah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'npsn',
        'nama',
        'alamat',
        'kode_wilayah',
        'kode_pos',
        'status',
        'kode_jenjang',
        'akreditasi',
        'email',
        'telepon',
        'kepemilikan',
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'latitude',
        'longitude',
        'users_id',
    ];


    // MstSekolah.php
    public function rombonganBelajars()
    {
        return $this->hasMany(MstRombel::class, 'sekolah_id'); // foreignKey di mst_rombel
    }


    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'id_sekolah');
    }

    public function ptks()
    {
        return $this->hasMany(MstGtk::class);
    }

    public function pesertaDidiks()
    {
        return $this->hasMany(PesertaDidik::class);
    }


    // Join ke tabel Jenjang pendidikan
    public function jenjang()
    {
        return $this->belongsTo(RefJenjangPendidikan::class, 'kode_jenjang', 'kode');
    }

    // public function rombonganBelajars()
    // {
    //     return $this->hasMany(RombonganBelajar::class);
    // }

    // public function prasaranas()
    // {
    //     return $this->hasMany(Prasarana::class);
    // }

    // public function saranas()
    // {
    //     return $this->hasMany(Sarana::class);
    // }

    // public function sarpras()
    // {
    //     return $this->hasMany(Sarpras::class);
    // }

    // public function wilayah()
    // {
    //     return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    // }

    // public function kepalaSekolah()
    // {
    //     return $this->belongsTo(MstGtk::class, 'kepala_sekolah_id');
    // }

    // public function operator()
    // {
    //     return $this->belongsTo(MstGtk::class, 'operator_id');
    // }

    // public function kurikulum()
    // {
    //     return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    // }

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'sekolah_id');
    // }

    protected static function booted()
    {
        static::saving(function ($sekolah) {
            if (empty($sekolah->slug) && $sekolah->nama && $sekolah->npsn) {
                $slug = Str::slug($sekolah->nama . '-' . $sekolah->npsn);

                $original = $slug;
                $counter = 1;
                while (MstSekolah::where('slug', $slug)->where('id', '!=', $sekolah->id)->exists()) {
                    $slug = $original . '-' . $counter++;
                }

                $sekolah->slug = $slug;
            }
        });
    }

    // untuk endpoint API
    // public function wilayah()
    // {
    //     return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    // }
}
