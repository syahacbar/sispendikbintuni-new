<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Ptk;
use App\Models\PesertaDidik;
use App\Models\RombonganBelajar;
use App\Models\Prasarana;
use App\Models\Sarana;

class Sekolah extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'tbl_sekolahs';
    protected $fillable = ['npsn', 'nama', 'alamat', 'kode_wilayah', 'status_sekolah', 'akreditasi'];

    public function ptks()
    {
        return $this->hasMany(Ptk::class);
    }
    public function pesertaDidiks()
    {
        return $this->hasMany(PesertaDidik::class);
    }
    public function rombonganBelajars()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
    public function prasaranas()
    {
        return $this->hasMany(Prasarana::class);
    }
    public function saranas()
    {
        return $this->hasMany(Sarana::class);
    }
}
