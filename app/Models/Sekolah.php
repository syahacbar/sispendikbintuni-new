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
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'npsn',
        'nama',
        'kurikulum_id',
        'jenjang',
        'alamat_jalan',
        'kode_pos',
        'status_sekolah',
        'akreditasi',
        'email',
        'telepon',
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'lintang',
        'bujur',
        'kode_wilayah',
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

    public function sarpras()
    {
        return $this->hasMany(Sarpras::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    }

    public function kepalaSekolah()
    {
        return $this->belongsTo(Ptk::class, 'kepala_sekolah_id');
    }

    public function operator()
    {
        return $this->belongsTo(Ptk::class, 'operator_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'sekolah_id');
    }

    protected static function booted()
    {
        static::saving(function ($sekolah) {
            if (empty($sekolah->slug) && $sekolah->nama && $sekolah->npsn) {
                $slug = Str::slug($sekolah->nama . '-' . $sekolah->npsn);

                $original = $slug;
                $counter = 1;
                while (Sekolah::where('slug', $slug)->where('id', '!=', $sekolah->id)->exists()) {
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
