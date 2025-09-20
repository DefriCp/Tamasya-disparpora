<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesaResource extends JsonResource
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
            'id_desa_bps' =>$this->id_desa_bps,
            'id_desa_kemendagri' =>$this->id_desa_kemendagri,
            'kecamatan' => $this->whenLoaded('kecamatan', fn () => $this->kecamatan->nama),
        
        ];
    }
}
