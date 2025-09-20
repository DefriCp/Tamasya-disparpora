<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TamasyaWisataResource extends JsonResource
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
            'slug' =>$this->slug,
            'jenis' =>$this->jenis,
            'desa' => $this->whenLoaded('desa', fn () => $this->desa->nama),
            'kecamatan' => $this->whenLoaded('kecamatan', fn () => $this->kecamatan->nama),
            'latitude' =>$this->latitude,
            'longitude' =>$this->longitude,
            'potensi_unggulan' =>$this->potensi_unggulan,
            'produk_unggulan' =>$this->produk_unggulan,
            'daya_tarik_wisata' =>$this->daya_tarik_wisata,
            'amenitas' =>$this->amenitas,
            'status_pemilik' =>$this->status_pemilik,
            'luas' =>$this->luas,
            'aktivitas' =>$this->aktivitas,
            'kondisi_akses' =>$this->kondisi_akses,
            'jarak_tempuh' =>$this->jarak_tempuh,
            'nama_pengelola' =>$this->nama_pengelola,
            'nomor_hp' =>$this->nomor_hp,
            'utilitas' => UtilitasResource::collection($this->whenLoaded('utilitas')),
            'photo' => PhotoTamasyaResource::collection($this->whenLoaded('photos'))
        ];
    }
}
