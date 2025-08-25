<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'section_type',
        'section_title',
        'section_data',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'section_data' => 'array',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
