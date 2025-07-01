<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sarana extends Model
{
    use HasUuids;

    protected $table = 'tbl_saranas';
    protected $fillable = ['sekolah_id', 'jenis_sarana', 'jumlah'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function prasarana()
    {
        return $this->belongsTo(Prasarana::class, 'kode_ruang', 'kode_ruang');
    }
}
