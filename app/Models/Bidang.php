<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'struktur_organisasi_id'
    ];

    public function strukturorganisasi(): BelongsTo
    {
        return $this->belongsTo(StrukturOrganisasi::class);
    }


}
