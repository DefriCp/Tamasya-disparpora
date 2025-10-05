<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TamasyaWisataResource;
use App\Models\DestinasiWisata;
use Illuminate\Http\Request;

class TamasyaWisataController extends Controller
{
    public function index()
    {
        $destinasiwisata = DestinasiWisata::with(['desa', 'kecamatan', 'utilitas', 'photos'])->get();
        return TamasyaWisataResource::collection($destinasiwisata);
    }
    
}
