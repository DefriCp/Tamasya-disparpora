<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans'; // Asumsi nama tabel
    protected $fillable = ['nama', 'id_kecamatan'];

    // Relasi ke Desa
    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class, 'kecamatan_id');
    }

    // --- PERBAIKAN PENTING DI SINI ---
    public function destinasi_wisata(): HasMany
    {
        // Parameter 2: 'kecamatan_id' (Nama kolom di tabel Destinasi Wisata - Baris 5)
        // Parameter 3: 'id' (Nama kolom PK di tabel Kecamatan - Baris 1)
        return $this->hasMany(DestinasiWisata::class, 'kecamatan_id', 'id');
    }
}