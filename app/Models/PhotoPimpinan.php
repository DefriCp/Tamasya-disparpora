<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PhotoPimpinan extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'photo',
        'struktur_organisasi_id'
    ];

    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(Pimpinan::class);
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
