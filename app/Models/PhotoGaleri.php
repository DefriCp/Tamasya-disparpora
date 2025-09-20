<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PhotoGaleri extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'galeri_id'
    ];

    public function galery(): BelongsTo
    {
        return $this->BelongsTo(Galeri::class);
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
