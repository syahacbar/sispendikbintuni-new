<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Prasarana extends Model
{
    use HasUuids;

    protected $table = 'tbl_prasaranas';
    protected $fillable = ['sekolah_id', 'jenis_prasarana', 'jumlah'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function saranas()
    {
        return $this->hasMany(Sarana::class, 'kode_ruang', 'kode_ruang');
    }
}
