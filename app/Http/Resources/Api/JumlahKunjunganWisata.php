<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JumlahKunjunganWisata extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? 'Data Belum Ada',
            'destinasi_wisata' => $this->whenLoaded('destinasiwisata', function () {
                return $this->destinasiwisata->nama ?? 'Data Belum Ada';
            }, 'Data Belum Ada'),
            'tahun' => $this->tahun ?? 'Data Belum Ada',
            'januari' => $this->januari ?? 'Data Belum Ada',
            'februari' => $this->februari ?? 'Data Belum Ada',
            'maret' => $this->maret ?? 'Data Belum Ada',
            'april' => $this->april ?? 'Data Belum Ada',
            'mei' => $this->mei ?? 'Data Belum Ada',
            'juni' => $this->juni ?? 'Data Belum Ada',
            'juli' => $this->juli ?? 'Data Belum Ada',
            'agustus' => $this->agustus ?? 'Data Belum Ada',
            'september' => $this->september ?? 'Data Belum Ada',
            'oktober' => $this->oktober ?? 'Data Belum Ada',
            'november' => $this->november ?? 'Data Belum Ada',
            'desember' => $this->desember ?? 'Data Belum Ada',
        ];
    }
}
