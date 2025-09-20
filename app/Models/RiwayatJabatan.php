<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatJabatan extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'nama',
        'struktur_organisasi_id'
    ];

    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(Pimpinan::class);
    }
}
