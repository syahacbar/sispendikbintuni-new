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

    public static function formatKodeWithDots(string $kode): string
    {
        $kode = preg_replace('/[^0-9]/', '', $kode); // Hanya angka
        return match (strlen($kode)) {
            2 => substr($kode, 0, 2),
            4 => substr($kode, 0, 2) . '.' . substr($kode, 2, 2),
            6 => substr($kode, 0, 2) . '.' . substr($kode, 2, 2) . '.' . substr($kode, 4, 2),
            10, 12 => substr($kode, 0, 2) . '.' . substr($kode, 2, 2) . '.' . substr($kode, 4, 2) . '.' . substr($kode, 6),
            default => $kode,
        };
    }

    public static function getNamaByKode(string $kode): ?string
    {
        $kodeFormatted = self::formatKodeWithDots($kode);
        return self::where('kode', $kodeFormatted)->value('nama');
    }
}
