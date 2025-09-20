<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Berita extends Model
{

    use HasFactory;

    protected $fillable = [
       'judul',
       'isi',
       'photo',
       'slug',
       'tags',
       'status',
       'dilihat',
       'waktu_publish',
       'header_id'
    ];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(Header::class);
    }

    // Accessor: ubah string menjadi array
    public function getTagsAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    // Mutator: ubah array menjadi string terpisah koma
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = is_array($value) ? implode(',', $value) : $value;
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
