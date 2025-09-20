<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pimpinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function photopimpinans(): HasMany
    {
        return $this->hasMany(PhotoPimpinan::class);
    }

    public function riwayatjabatans(): HasMany
    {
        return $this->hasMany(RiwayatJabatan::class);
    }

}
