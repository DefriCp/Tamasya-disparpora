<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeaderResource extends JsonResource
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
            'skpd' => $this->skpd,
            'warna_pertama' =>$this->warna_pertama,
            'warna_kedua' =>$this->warna_kedua,
            'singkatan_skpd' =>$this->singkatan_skpd,
            'warna_text_header' =>$this->warna_text_header,
            'warna_text_utama' =>$this->warna_text_utama
        ];
    }
}
