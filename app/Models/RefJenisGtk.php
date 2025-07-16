<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefJenisGtk extends Model
{
    use HasUuids;

    protected $table = 'ref_jenis_gtk';

    protected $fillable = [
        'nama',
    ];
}
