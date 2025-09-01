<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'user_id',
        'platform',
        'status',
        'sync_method',
        'request_data',
        'response_data',
        'error_message',
        'started_at',
        'completed_at',
        'execution_time',
        'bot_logs',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'bot_logs' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeForPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
