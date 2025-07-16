<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefJenjangPendidikan extends Model
{
    use HasUuids;

    protected $table = 'ref_jenjang_pendidikan';

    protected $fillable = [
        'nama',
        'kode',
    ];

    public function sekolahs()
    {
        return $this->hasMany(MstSekolah::class, 'kode_jenjang', 'kode');
    }
}
