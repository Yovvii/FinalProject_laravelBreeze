<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaporFile extends Model
{
    protected $fillable = [
        'user_id',
        'semester',
        'file_rapor'
    ];
}
