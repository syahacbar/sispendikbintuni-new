<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ExtBannerMobile extends Model
{
    use HasFactory;

    protected $table = 'ext_banner_mobiles';

    public $incrementing = false; // Karena menggunakan UUID

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID saat membuat model baru
        static::creating(function ($model) {
            $model->id = $model->id ?? (string) Str::uuid();
        });
    }
}
