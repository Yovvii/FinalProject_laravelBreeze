<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'user_id',
        'mapel_id',
        'semester',
        'nilai_semester',
    ];

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
