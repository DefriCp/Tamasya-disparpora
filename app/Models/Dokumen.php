<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dokumen extends Model
{
   
    use HasFactory;

    protected $fillable = [
        'nama',
        'file',
        'tahun'
    ];

    protected static function booted()
    {
        static::deleting(function ($record) {
            if ($record->file && Storage::disk('public')->exists($record->file)) {
                Storage::disk('public')->delete($record->file);
            }
        });
    }
}
