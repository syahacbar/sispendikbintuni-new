<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KelompokMapel extends Model
{
    use HasUuids;

    protected $table = 'tbl_kelompok_mapels';

    protected $fillable = ['nama'];
}
