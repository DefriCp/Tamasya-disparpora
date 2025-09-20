<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Header extends Model
{

    use HasFactory;

    protected $fillable = [
        'skpd',
        'warna_pertama',
        'warna_kedua',
        'singkatan_skpd',
        'warna_text_header',
        'warna_text_utama'

    ];

    public function logos(): HasMany
    {
        return $this->hasMany(Logo::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    protected static function booted()
    {
        static::deleting(function ($record) {
            if ($record->photo && Storage::disk('public')->exists($record->photo)) {
                Storage::disk('public')->delete($record->photo);
            }

            if ($record->logo && Storage::disk('public')->exists($record->logo)) {
                Storage::disk('public')->delete($record->logo);
            }
        });
    }

    

    


}
