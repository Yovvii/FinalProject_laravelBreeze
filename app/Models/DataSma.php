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
}
