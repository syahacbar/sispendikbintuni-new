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


    public function getLevelAttribute(): string
    {
        $length = strlen(str_replace('.', '', $this->kode));
        return match ($length) {
            2 => 'provinsi',
            4 => 'kabupaten',
            6 => 'kecamatan',
            10 => 'kelurahan',
            default => 'unknown',
        };
    }

    public function getParentKodeAttribute(): ?string
    {
        return match ($this->level) {
            'kabupaten' => substr($this->kode, 0, 2),
            'kecamatan' => substr($this->kode, 0, 5),
            'kelurahan' => substr($this->kode, 0, 8),
            default => null,
        };
    }
}
