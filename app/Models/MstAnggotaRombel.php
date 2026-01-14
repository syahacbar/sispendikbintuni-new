<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Validation\ValidationException;

class MstAnggotaRombel extends Model
{
    use HasUuids;

    protected $table = 'mst_anggota_rombel';

    protected $fillable = [
        'rombel_id',
        'peserta_didik_id',
        'status_keaktifan',
        'tanggal_masuk',
        'tanggal_keluar',
        'keterangan',
    ];

    protected static function booted()
    {
        static::creating(function ($record) {
            $exists = self::where('peserta_didik_id', $record->peserta_didik_id)
                ->where('rombel_id', $record->rombel_id)
                ->where('status_keaktifan', true)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'peserta_didik_id' =>
                        'Peserta didik sudah terdaftar di rombel ini.',
                ]);
            }
        });
    }

    // public function rombonganBelajar()
    // {
    //     return $this->belongsTo(MstRombel::class);
    // }

    public function rombel()
    {
        return $this->belongsTo(MstRombel::class, 'rombel_id');
    }

    public function pesertaDidik()
    {
        return $this->belongsTo(MstPesertaDidik::class, 'peserta_didik_id');
    }
}
