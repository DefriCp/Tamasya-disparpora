<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_kecamatan'
    ];

    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class);
    }

    public function destinasi_wisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class);
    }
}
