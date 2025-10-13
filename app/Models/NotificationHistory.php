<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    use HasFactory;

    protected $table = 'notification_histories';
    
    protected $fillable = [
        'user_id',
        'type', // 'success' atau 'error'
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean', // Memastikan kolom ini dikonversi ke boolean
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}