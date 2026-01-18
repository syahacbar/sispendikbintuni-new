<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstPesertaDidik extends Model
{
    use HasUuids;

    protected $table = 'mst_peserta_didik';

    protected $fillable = [
        'nama',
        'nisn',
        'nipd',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kode_wilayah',
        'kode_pos',
    ];

    public function wilayah()
    {
        return $this->belongsTo(RefWilayah::class, 'kode_wilayah', 'kode');
    }

    public function anggotaRombel()
    {
        return $this->hasMany(MstAnggotaRombel::class, 'peserta_didik_id');
    }

    public function rombels()
    {
        return $this->belongsToMany(
            MstRombel::class,
            'mst_anggota_rombel',
            'peserta_didik_id',
            'rombel_id'
        );
    }

    /**
     * Check if student is OAP (Orang Asli Papua) based on kode_wilayah or tempat_lahir
     * 
     * Uses hybrid approach:
     * 1. If kode_wilayah is available, use province code (91-95 = Papua) - takes full precedence
     * 2. If kode_wilayah is empty, fall back to tempat_lahir keyword matching
     * 
     * @return bool
     */
    public function isOap(): bool
    {
        // Method 1: Check kode_wilayah if available - takes full precedence
        if (!empty($this->kode_wilayah)) {
            // Get first 2 digits of kode_wilayah (province code)
            $kodeClean = str_replace('.', '', $this->kode_wilayah);
            $provinceCode = substr($kodeClean, 0, 2);

            // Papua province codes: 91, 92, 93, 94, 95
            // 91 = Papua
            // 92 = Papua Barat
            // 93 = Papua Selatan
            // 94 = Papua Tengah
            // 95 = Papua Pegunungan
            return in_array($provinceCode, ['91', '92', '93', '94', '95']);
        }

        // Method 2: Fallback to tempat_lahir keyword matching (only if no kode_wilayah)
        if (!empty($this->tempat_lahir)) {
            $papuaKeywords = [
                'Papua',
                'Bintuni',
                'Sorong',
                'Manokwari',
                'Jayapura',
                'Merauke',
                'Nabire',
                'Timika',
                'Fakfak',
                'Kaimana',
                'Wamena',
                'Biak',
                'Serui',
                'Ransiki',
            ];

            foreach ($papuaKeywords as $keyword) {
                if (stripos($this->tempat_lahir, $keyword) !== false) {
                    return true;
                }
            }
        }

        return false;
    }
}
