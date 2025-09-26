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
        'jumlah',
        'bulan',
        'tahun'
    ];

    public function destinasiwisata(): BelongsTo
    {
        return $this->belongsTo(BelongsTo::class);
    }
}
