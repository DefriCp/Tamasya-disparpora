<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BeritaResource;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class BeritaController extends Controller
{
    public function index()
    {
        $berita = berita::with(['header'])
            ->where('status', 'publish')
            ->get();

        return BeritaResource::collection($berita);
    }


    public function terbaru(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 5);

        $berita = Berita::with('header')
            ->where('status', 'publish')
            ->orderByDesc('waktu_publish')
            ->paginate($perPage);

        return response()->json([
            'data' => BeritaResource::collection($berita),
            'meta' => [
                'current_page' => $berita->currentPage(),
                'from' => $berita->firstItem(),
                'last_page' => $berita->lastPage(),
                'per_page' => $berita->perPage(),
                'to' => $berita->lastItem(),
                'total' => $berita->total(),
            ]
        ]);
    }

    // Tampilkan 5 berita paling populer
    public function populer(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 5); // default 5 per halaman

        $berita = berita::with('header')
            ->where('status', 'publish')
            ->orderByDesc('dilihat')
            ->paginate($perPage);

        return response()->json([
            'data' => BeritaResource::collection($berita),
            'meta' => [
                'current_page' => $berita->currentPage(),
                'from' => $berita->firstItem(),
                'last_page' => $berita->lastPage(),
                'per_page' => $berita->perPage(),
                'to' => $berita->lastItem(),
                'total' => $berita->total(),
            ]
        ]);
    }
}
