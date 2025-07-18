<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefSarpras extends Model
{
    use HasUuids;

    use HasUuids;

    protected $table = 'ref_sarpras';

    protected $fillable = [
        'nama',
        'kategori',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class);
    }
}
