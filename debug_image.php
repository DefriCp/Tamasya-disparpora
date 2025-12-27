<?php

use App\Models\DestinasiWisata;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 16;
$wisata = DestinasiWisata::find($id);

if (!$wisata) {
    echo "Wisata with ID $id not found.\n";
    exit;
}

echo "Nama: " . $wisata->nama . "\n";
echo "Cover Image DB Value: " . ($wisata->cover_image ?? 'NULL') . "\n";

if ($wisata->cover_image) {
    $path = 'public/' . $wisata->cover_image; // Storage disk 'public' maps to storage/app/public
    // Note: Storage::disk('public')->exists($wisata->cover_image) checks in storage/app/public
    $exists = Storage::disk('public')->exists($wisata->cover_image);
    echo "File exists in Storage (public disk): " . ($exists ? 'YES' : 'NO') . "\n";
    
    $realPath = storage_path('app/public/' . $wisata->cover_image);
    echo "Full Path: " . $realPath . "\n";
} else {
    echo "No cover image set.\n";
}

// Check if gallery has photos
echo "Gallery Photos Count: " . $wisata->photos->count() . "\n";
if ($wisata->photos->count() > 0) {
    echo "First Photo: " . $wisata->photos->first()->photo . "\n";
}
