<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Galeri extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'nama',
        'photo_id'
    ];


    public function photogaleris(): HasMany
    {
        return $this->hasMany(PhotoGaleri::class);
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
