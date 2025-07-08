<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JenisSarpras extends Model
{
    use HasUuids;

    protected $table = 'tbl_jenis_sarpras';

    protected $fillable = [
        'id',
        'nama',
    ];
}
