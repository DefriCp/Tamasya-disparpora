<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TentangKami extends Model
{
    use HasFactory;

    protected $fillable = [
        'sejarah',
        'photo',
        'visi',
        'misi',
        'alamat',
        'no_hp',
        'email'
    ];

    protected static function booted()
    {
        static::deleting(function ($record) {
            if ($record->photo && Storage::disk('public')->exists($record->photo)) {
                Storage::disk('public')->delete($record->photo);
            }
        });
    }
}
