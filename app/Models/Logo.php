<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Logo extends Model
{

    use HasFactory;

    protected $fillable = [
        'logo',
        'header_id'
    ];

    public function headers(): BelongsTo
    {
        return $this->belongsTo(Header::class);
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
