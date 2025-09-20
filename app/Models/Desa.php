<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_desa_bps',
        'id_desa_kemendagri',
        'kecamatan_id',
    ];
    
    public function kecamatan():BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }
    
    public function destinasi_wisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class);
    }
    
}
