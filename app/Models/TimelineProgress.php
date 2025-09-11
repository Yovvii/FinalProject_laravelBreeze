<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimelineProgress extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'timeline_progress';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'sma_id',
        'current_step',
    ];

    /**
     * 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sma(): BelongsTo
    {
        return $this->belongsTo(DataSma::class, 'sma_id');
    }
}
