<?php

namespace App\Http\Controllers\Api;

use App\Filament\Resources\PengumumResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BeritaResource;
use App\Http\Resources\Api\PengumumanResource;
use App\Models\Pengumum;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumum = Pengumum::with(['header'])->get();

        return PengumumanResource::collection($pengumum);
    }

    public function show($id)
    {
        $pengumuman = pengumum::find($id);

        if (!$pengumuman) {
            return response()->json(['message' => 'Pengumuman tidak ditemukan'], 404);
        }

        $data = [
            'id' => $pengumuman->id,
            'judul' => $pengumuman->judul,
            'slug' => $pengumuman->slug,
            'isi' => $pengumuman->isi,
            'tanggal_publish' => $pengumuman->tanggal_publish,
            'selesai_publish' => $pengumuman->selesai_publish,
        ];

        return response()->json($data);
    }
}
