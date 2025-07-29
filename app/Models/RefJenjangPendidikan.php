<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefJenjangPendidikan extends Model
{
    use HasUuids;

    protected $table = 'ref_jenjang_pendidikan';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'kode',
    ];
}
