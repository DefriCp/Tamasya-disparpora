<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncDataController extends Controller
{
    public function sync()
    {
        $urlAPI = "https://tamasya.tasikmalayakab.go.id/api/tamasyawisata";
        $response = file_get_contents($urlAPI);
        $data = json_decode($response, true);
        // return response()->json($data);

        $kec=random_int(1,39);
        $desa=random_int(1,351);
        foreach ($data['data'] as $item) {
            \App\Models\DestinasiWisata::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'nama' => $item['nama'],
                    'jenis' => $item['jenis'],
                    'kecamatan_id' => $kec,
                    'desa_id' => $desa,
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'potensi_unggulan' => $item['potensi_unggulan'],
                    'produk_unggulan' => $item['produk_unggulan'],
                    'daya_tarik_wisata' => $item['daya_tarik_wisata'],
                    'amenitas' => $item['amenitas'],
                    'status_pemilik' => $item['status_pemilik'],
                    'luas' => $item['luas'],
                    'aktivitas' => $item['aktivitas'],
                    'kondisi_akses' => $item['kondisi_akses'],
                    'jarak_tempuh' => $item['jarak_tempuh'],
                    'nama_pengelola' => $item['nama_pengelola'],
                    'nomor_hp' => $item['nomor_hp'],
                ]
            );
        }
    }

    
}
