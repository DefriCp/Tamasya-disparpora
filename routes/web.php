<?php

use App\Http\Controllers\BerandaController;
use Illuminate\Support\Facades\Route;



//--------------------------------------------------------------------------
//  Route Fronetend
//--------------------------------------------------------------------------
Route::group(['as' => 'fe.', 'prefix' => '/'], function () {
    Route::get('/', [BerandaController::class, 'beranda'])->name('beranda');

    Route::get('/tentang-kami', [BerandaController::class, 'tentang'])->name('tentang');
    Route::get('/profile-pimpinan', [BerandaController::class, 'profilePimpinan'])->name('profile.pimpinan');
    Route::get('/struktur-organisasi', [BerandaController::class, 'strukturOrganisasi'])->name('struktur-organisasi');

    Route::get('/berita', [BerandaController::class, 'berita'])->name('berita');
    Route::get('/berita/{slug?}', [BerandaController::class, 'detailBerita'])->name('berita.detail');

    Route::get('/tamasya-wisata', [BerandaController::class, 'wisata'])->name('wisata');
    // Route::get('/wisata/{slug?}', [BerandaController::class, 'detailWisata'])->name('wisata.detail');

    Route::get('/tamasya-wisata/{slug?}', [BerandaController::class, 'detailTamsyaWisata'])->name('wisata.detail');

    Route::get('/galeri', [BerandaController::class, 'galeri'])->name('galeri');

    Route::get('/layanan', [BerandaController::class, 'layanan'])->name('layanan');

    Route::get('/dokumen', [BerandaController::class, 'dokumen'])->name('dokumen');

    // Route Ajax Get Berita Kab Tasik
    Route::get('/get-berita-kabtsm/', [BerandaController::class, 'getBeritaKabTsm'])->name('getBeritaKabTsm');

    // Route Ajax Get Agenda
    Route::post('/get-agenda/', [BerandaController::class, 'getAgenda'])->name('getAgenda');

    // Route Ajax Get Pengumuman By Id
    Route::get('/get-pengumuman-by/{id?}', [BerandaController::class, 'getPengumumanById'])->name('getPengumumanById');
});
