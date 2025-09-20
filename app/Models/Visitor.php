<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{

    use HasFactory;

    protected $fillable = ['visited_at'];
    protected $dates = ['visited_at'];
}
