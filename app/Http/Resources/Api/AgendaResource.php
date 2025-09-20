<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgendaResource extends JsonResource
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
            'judul' =>$this->judul,
            'slug' =>$this->slug,
            'deskripsi' =>$this->deskripsi,
            'lokasi' =>$this->lokasi,
            'status' =>$this->status,
            'link' =>$this->link,
            'tanggal' =>$this->tanggal,
            'waktu_mulai' =>$this->waktu_mulai,
            'waktu_selesai' =>$this->waktu_selesai
        ];
    }
}
