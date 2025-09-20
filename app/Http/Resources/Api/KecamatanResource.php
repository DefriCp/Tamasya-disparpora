<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KecamatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' =>$this->id,
            'nama' =>$this->nama,
            'id_kecamatan' =>$this->id_kecamatan,
            'desas' => $this->desas->map(function ($desa) {
                return [
                    'id' => $desa->id,
                    'nama' => $desa->nama,
                ];
            }),
        ];
    }
}
