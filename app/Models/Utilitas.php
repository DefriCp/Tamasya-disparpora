<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'keterangan',
        'destinasi_wisata_id'
    ];

    public function destinasiWisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class);
    }
}
