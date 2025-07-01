<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Sekolah extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'tbl_sekolahs';

    protected $fillable = [
        'npsn',
        'nama',
        'jenjang',
        'alamat_jalan',
        'desa_kelurahan',
        'kode_pos',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_wilayah',
        'status_sekolah',
        'akreditasi',
        'email',
        'telepon',
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'slug',
    ];

    // Relasi opsional jika digunakan
    public function ptks()
    {
        return $this->hasMany(Ptk::class);
    }

    public function pesertaDidiks()
    {
        return $this->hasMany(PesertaDidik::class);
    }

    public function rombonganBelajars()
    {
        return $this->hasMany(RombonganBelajar::class);
    }

    public function prasaranas()
    {
        return $this->hasMany(Prasarana::class);
    }

    public function saranas()
    {
        return $this->hasMany(Sarana::class);
    }

    protected static function booted()
    {
        static::saving(function ($sekolah) {
            if (empty($sekolah->slug) && $sekolah->nama && $sekolah->npsn) {
                $slug = Str::slug($sekolah->nama . '-' . $sekolah->npsn);

                // Opsional: pastikan slug unik
                $original = $slug;
                $counter = 1;
                while (Sekolah::where('slug', $slug)->where('id', '!=', $sekolah->id)->exists()) {
                    $slug = $original . '-' . $counter++;
                }

                $sekolah->slug = $slug;
            }
        });
    }
}
