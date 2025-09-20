<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PhotoDestinasiWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'destinasi_wisata_id'
    ];

    public function destinasi_wisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class);
    }

    protected static function booted()
    {
        static::deleting(function ($record) {
            if ($record->photo && Storage::disk('public')->exists($record->photo)) {
                Storage::disk('public')->delete($record->photo);
            }
        });
    }
}
