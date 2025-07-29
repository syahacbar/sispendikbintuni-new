<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstPembelajaran extends Model
{
    use HasUuids;

    protected $table = 'mst_pembelajaran';

    protected $fillable = [
        'rombongan_belajar_id',
        'mata_pelajaran_id',
        'gtk_id',
        'semester_id',
        'jam_mengajar_per_minggu',
        'jenis_pembelajaran',
        'status_aktif',
        'tgl_mulai',
        'tgl_selesai',
        'keterangan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'id_sekolah');
    }


    public function rombel()
    {
        return $this->belongsTo(MstRombel::class, 'rombongan_belajar_id');
    }

    public function mapel()
    {
        return $this->belongsTo(RefMapel::class, 'mata_pelajaran_id');
    }

    public function gtk()
    {
        return $this->belongsTo(MstGtk::class, 'gtk_id');
    }

    public function semester()
    {
        return $this->belongsTo(RefSemester::class, 'semester_id');
    }
}
