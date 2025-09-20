<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Wisata extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'deskripsi',
        'slug',
    ];

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function photowisatas(): HasMany
    {
        return $this->hasMany(PhotoWisata::class);
    }
}
