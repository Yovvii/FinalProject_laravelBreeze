<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSma extends Model
{
    use HasFactory;

    protected $table = 'sma_datas';

    protected $fillable = [
        'nama_sma',
        'akreditasi_id',
    ];

    public function akreditasi()
    {
        return $this->belongsTo(Akreditasi::class, 'akreditasi_id');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'sma_data_id')->where('role', 'admin_sekolah');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'data_sma_id');
    }
}
