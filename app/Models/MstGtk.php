<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MstGtk extends Model
{
    use HasUuids;

    protected $table = 'mst_gtk';

    protected $fillable = [
        'nama',
        'nik',
        'nip',
        'nuptk',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'status_kepegawaian',
        'jenis_gtk',
        'pend_terakhir',
        'status_keaktifan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'sekolah_id'); // sesuaikan jika beda kolom
    }

    public function jenisGtk()
    {
        return $this->belongsTo(RefJenisGtk::class, 'jenis_gtk', 'id');
    }
}
