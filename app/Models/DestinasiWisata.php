<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DestinasiWisata extends Model
{
    use HasFactory;
    
    // Sesuaikan nama tabel
    protected $table = 'destinasi_wisatas';

    protected $fillable = [
        'nama',
        'slug',
        'cover_image',
        'jenis',
        'kecamatan_id', // Ini Foreign Key ke tabel Kecamatan
        'desa_id',      // Ini Foreign Key ke tabel Desa
        'latitude',
        'longitude',
        'potensi_unggulan',
        'produk_unggulan',
        'daya_tarik_wisata',
        'amenitas',
        'status_pemilik',
        'luas',
        'aktivitas',
        'kondisi_akses',
        'jarak_tempuh',
        'nama_pengelola',
        'nomor_hp'
    ];

    protected $casts = [
        'jenis' => 'array',
    ];

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // --- PERBAIKAN: GUNAKAN KUNCI EKSPLISIT ---
    public function kecamatan(): BelongsTo
    {
        // Parameter 2: 'kecamatan_id' (Foreign Key di tabel destinasi_wisatas ini)
        // Parameter 3: 'id' (Primary Key di tabel kecamatans)
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    public function desa(): BelongsTo
    {
        // Parameter 2: 'desa_id' (Foreign Key di tabel destinasi_wisatas ini)
        // Parameter 3: 'id' (Primary Key di tabel desas)
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }
    // -------------------------------------------

    public function utilitas(): HasMany
    {
        return $this->hasMany(Utilitas::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoDestinasiWisata::class);
    }

    public function jumlahkunjunganwisatas(): HasMany
    {
        return $this->hasMany(JumlahKunjunganWisata::class);
    }
}