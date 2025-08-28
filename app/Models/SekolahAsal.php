<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SekolahAsal extends Model
{
    use HasFactory;

    protected $table = 'sekolah_asals';

    protected $fillable = [
        'nama_sekolah',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'sekolah_asal_id');
    }
}
