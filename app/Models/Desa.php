<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'id_desa_bps', 'id_desa_kemendagri', 'kecamatan_id'];
    
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
    
    // KOREKSI: Gunakan HasMany
    public function destinasi_wisata(): HasMany
    {
        return $this->hasMany(DestinasiWisata::class, 'desa_id');
    }
}