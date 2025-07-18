<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class MstSekolah extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'mst_sekolah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'npsn',
        'nama',
        'alamat',
        'kode_wilayah',
        'kode_pos',
        'status',
        'kode_jenjang',
        'akreditasi',
        'email',
        'telepon',
        'kepemilikan',
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'latitude',
        'longitude',
        'users_id',
    ];


    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'id_sekolah');
    }


    // Relasi ke jenjang
    public function jenjang()
    {
        return $this->belongsTo(RefJenjangPendidikan::class, 'kode_jenjang', 'kode');
    }

    // Relasi ke rombel
    public function rombonganBelajars()
    {
        return $this->hasMany(MstRombel::class, 'sekolah_id');
    }

    // Relasi ke anggota rombel → peserta didik
    public function pesertaDidiks()
    {
        return $this->hasManyThrough(
            MstPesertaDidik::class,
            MstAnggotaRombel::class,
            'rombel_id', // foreign key di MstAnggotaRombel
            'id', // foreign key di MstPesertaDidik
            'id', // local key di MstSekolah (via rombel)
            'peserta_didik_id' // foreign key di MstAnggotaRombel
        );
    }

    public function gtkGuru()
    {
        return $this->hasManyThrough(
            MstGtk::class,
            MstRombel::class,
            'sekolah_id',         // Foreign key di mst_rombel yang mengarah ke mst_sekolah
            'id',                 // Foreign key di mst_gtk yang dicari berdasarkan wali_kelas_ptk_id
            'id',                 // Primary key di mst_sekolah
            'wali_kelas_ptk_id'   // Foreign key di mst_rombel yang mengarah ke mst_gtk
        )->whereHas('jenis', function ($q) {
            $q->where('nama', 'Guru');
        });
    }

    // Relasi ke GTK (jenis Pegawai)
    public function gtkPegawai()
    {
        return $this->hasManyThrough(
            MstGtk::class,
            MstRombel::class,
            'sekolah_id',
            'id',
            'id',
            'wali_kelas_ptk_id'
        )->whereHas('jenis', function ($q) {
            $q->where('nama', '!=', 'Guru');
        });
    }

    // Relasi tidak langsung ke GTK (via rombel)
    public function ptks()
    {
        return $this->hasManyThrough(
            MstGtk::class,
            MstRombel::class,
            'sekolah_id',         // Foreign key di mst_rombel yang mengarah ke mst_sekolah
            'id',                 // Foreign key di mst_gtk (id dicocokkan dengan wali_kelas_ptk_id)
            'id',                 // Local key di mst_sekolah
            'wali_kelas_ptk_id'   // Foreign key di mst_rombel yang mengarah ke mst_gtk
        );
    }


    public function sarpras()
    {
        return $this->belongsToMany(
            RefSarpras::class,
            'mst_sarpras_sekolah',
            'sekolah_id',
            'sarpras_id'
        )->withPivot('jumlah_saat_ini', 'jumlah_ideal', 'keterangan');
    }

    public function mstSarprasSekolah()
    {
        return $this->hasMany(MstSarprasSekolah::class, 'sekolah_id');
    }

    protected static function booted()
    {
        static::saving(function ($sekolah) {
            if (empty($sekolah->slug) && $sekolah->nama && $sekolah->npsn) {
                $slug = Str::slug($sekolah->nama . '-' . $sekolah->npsn);

                $original = $slug;
                $counter = 1;
                while (MstSekolah::where('slug', $slug)->where('id', '!=', $sekolah->id)->exists()) {
                    $slug = $original . '-' . $counter++;
                }

                $sekolah->slug = $slug;
            }
        });
    }
}
