<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefMapel extends Model
{
    use HasUuids;

    protected $table = 'ref_mapel';

    protected $fillable = ['kode', 'nama'];
}
