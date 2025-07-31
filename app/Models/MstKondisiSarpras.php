<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstKondisiSarpras extends Model
{
    use HasUuids;

    protected $table = 'mst_kondisi_sarpras';

    protected $fillable = [
        'id',
        'id_mst_sarpras',
        'kondisi',
        'jumlah',
        'keterangan',
    ];

    public function sarpras(): BelongsTo
    {
        return $this->belongsTo(MstSarprasSekolah::class, 'id_mst_sarpras');
    }
}
