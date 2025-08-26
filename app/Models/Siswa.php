<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nisn',
        'tanggal_lahir',
        'kabupaten',
        'kecamatan',
        'desa',
        'alamat',
        'no_kk',
        'nik',
        'no_hp',
        'nama_ayah',
        'nama_ibu',
        'agama',
        'kebutuhan_k',
        'sekolah_asals_id', // ada foreign key tabel sekolah_asals
        'akta',
        'foto',
      ];
      
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ortu()
    {
        return $this->hasOne(Ortu::class);
    }
}
