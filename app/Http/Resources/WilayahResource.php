<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WilayahResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'kode' => $this->kode,
            'nama' => $this->nama,
            'sekolah' => $this->sekolahs->map(function ($s) {
                return [
                    'nama' => $s->nama,
                    'jenjang' => $s->jenjang,
                    'npsn' => $s->npsn,
                ];
            }),
        ];
    }
}
