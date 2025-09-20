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

    protected $fillable = [
        'nama',
        'slug',
        'jenis',
        'kecamatan_id',
        'desa_id',
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

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected $casts = [
        'jenis' => 'array', 
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function utilitas(): HasMany
    {
        return $this->hasMany(Utilitas::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoDestinasiWisata::class);
    }
}
