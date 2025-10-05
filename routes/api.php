<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\DesaController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\JumlahKunjunganWisataController;
use App\Http\Controllers\Api\KecamatanController;
use App\Http\Controllers\Api\LayananController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\TamasyaWisataController;
use App\Http\Controllers\Api\WisataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//  Api Berita
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/terbaru', [BeritaController::class, 'terbaru']);
Route::get('/berita/terpopuler', [BeritaController::class, 'populer']);

//  Api Pengumuman By Id

Route::apiResource('/agenda', AgendaController::class);
Route::apiResource('/dokumen', DokumenController::class);
Route::apiResource('/layanan', LayananController::class);
Route::apiResource('/wisata', WisataController::class);
Route::apiResource('/pengumuman', PengumumanController::class);


//Api Destinasi Wisata
Route::apiResource('/tamasyawisata', TamasyaWisataController::class);

Route::apiResource('/desa', DesaController::class);

Route::apiResource('/kecamatan', KecamatanController::class);

Route::apiResource('/jumlahkunjunganwisata', JumlahKunjunganWisataController::class);
