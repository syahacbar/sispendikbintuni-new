<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefKurikulum extends Model
{
    use HasUuids;

    protected $table = 'ref_kurikulum';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'tahun_mulai',
        'status',
    ];
}
