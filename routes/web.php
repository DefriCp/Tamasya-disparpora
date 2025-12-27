<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [BerandaController::class, 'beranda'])
    ->name('fe.beranda');

/* ================= WISATA ================= */
Route::get('/tamasya-wisata', [BerandaController::class, 'wisata'])
    ->name('fe.wisata');

Route::get('/tamasya-wisata/{slug}', [BerandaController::class, 'detailWisata'])
    ->name('fe.wisata.detail');

/* ================= PETA (Tambahkan Ini) ================= */
Route::get('/peta-wisata', [BerandaController::class, 'petaWisata'])
    ->name('fe.peta');

/* ================= BERITA ================= */
Route::get('/berita', [BerandaController::class, 'beritaWisata'])
    ->name('fe.berita');

Route::get('/berita/{slug}', [BerandaController::class, 'detailBeritaWisata'])
    ->name('fe.berita.detail');

/* ================= GALERI ================= */
Route::get('/galeri', [BerandaController::class, 'galeri'])
    ->name('fe.galeri');
