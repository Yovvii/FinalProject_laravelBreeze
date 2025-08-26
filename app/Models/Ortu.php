<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ortu extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'nama_wali',
        'tempat_lahir_wali',
        'tanggal_lahir_wali',
        'pekerjaan_wali',
        'alamat_wali',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
