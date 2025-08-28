<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nisn',
        'jenis_kelamin',
        'tanggal_lahir',
        'kabupaten',
        'kecamatan',
        'desa',
        'alamat', // error di sini
        'no_kk',
        'nik',
        'no_hp',
        'nama_ayah',
        'nama_ibu',
        'agama',
        'kebutuhan_k',
        'sekolah_asal_id', // ada foreign key tabel sekolah_asals
        'akta',
        'foto',
      ];
      
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ortu(): HasOne
    {
        return $this->hasOne(Ortu::class);
    }

    public function sekolahAsal(): BelongsTo
    {
        return $this->belongsTo(SekolahAsal::class, 'sekolah_asal_id');
    }
}
