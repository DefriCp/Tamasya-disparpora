<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoTamasyaResource extends JsonResource
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
            'photo' => $this->photo ? asset('storage/' . $this->photo) : null,
            'destinasi_wisata_id' =>$this->destinasi_wisata_id,
        ];
    }
}
