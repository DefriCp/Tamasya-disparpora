<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'isi' => $this->isi,
            'photo' => $this->photo ? asset('storage/' . $this->photo) : null,
            'slug' => $this->slug,
            'tags' => $this->tags,
            'status' => $this->status,
            'dilihat' => $this->dilihat,
            'waktu_publish' => $this->waktu_publish,
            'penulis' => $this->whenLoaded('header', fn () => $this->header->singkatan_skpd),
        ];
    }
}
