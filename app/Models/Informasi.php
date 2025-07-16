<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;


class Informasi extends Model
{
    use HasUuids;

    protected $table = 'ext_informasi';
    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'gambar',
        'slug',
        'lihat',
        'users_id',
    ];

    // public function sekolah()
    // {
    //     return $this->belongsTo(Sekolah::class);
    // }


    protected static function booted()
    {
        static::saving(function ($informasi) {
            if (empty($informasi->slug) && $informasi->judul) {
                $slug = Str::slug($informasi->judul);

                // Opsional: pastikan slug unik
                $original = $slug;
                $counter = 1;
                while (Informasi::where('slug', $slug)->where('id', '!=', $informasi->id)->exists()) {
                    $slug = $original . '-' . $counter++;
                }

                $informasi->slug = $slug;
            }
        });
    }

    public function getShortDescAttribute()
    {
        return Str::limit(strip_tags($this->deskripsi), 100);
    }
}
