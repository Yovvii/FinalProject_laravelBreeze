<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
