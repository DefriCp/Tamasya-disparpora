<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JumlahKunjunganWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'januari',
        'februari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agustus',
        'september',
        'oktober',
        'november',
        'desember',
        'tahun',
        'destinasi_wisata_id'
    ];

    public function destinasiwisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class, 'destinasi_wisata_id');
    }
}
