<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    protected $fillable = [
        'siswa_id', 'aksi', 'deskripsi', 'data_sebelumnya'
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
