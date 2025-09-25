<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Akreditasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_akreditasi',
        'warna_background',
        'warna_text',
    ];
}
