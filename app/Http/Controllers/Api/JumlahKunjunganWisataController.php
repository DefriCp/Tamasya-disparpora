<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\JumlahKunjunganWisata as ApiJumlahKunjunganWisata;
use App\Models\JumlahKunjunganWisata;
use Illuminate\Http\Request;

class JumlahKunjunganWisataController extends Controller
{
    public function index()
    {
        $jumlahKunjunganWisata = JumlahKunjunganWisata::with(['destinasiwisata'])->get();
        return ApiJumlahKunjunganWisata::collection($jumlahKunjunganWisata);
    }
}
