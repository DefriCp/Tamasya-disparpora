<?php

use App\Models\DestinasiWisata;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 16;
$wisata = DestinasiWisata::find($id);

$result = [
    'id' => $id,
    'nama' => $wisata ? $wisata->nama : null,
    'cover_image' => $wisata ? $wisata->cover_image : null,
    'photos_count' => $wisata ? $wisata->photos->count() : 0,
    'first_photo' => ($wisata && $wisata->photos->first()) ? $wisata->photos->first()->photo : null,
    'file_exists' => ($wisata && $wisata->cover_image) ? Storage::disk('public')->exists($wisata->cover_image) : false,
];

echo json_encode($result);
