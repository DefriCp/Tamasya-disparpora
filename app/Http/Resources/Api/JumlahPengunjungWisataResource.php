<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JumlahPengunjungWisataResource extends JsonResource
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
            'jumlah' =>$this->jumlah,
            'bulan' =>$this->bulan,
            'tahun' =>$this->tahun,
        ];
    }
}
