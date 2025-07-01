<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'tbl_wilayahs';
    protected $fillable = ['kode', 'nama'];

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
}
