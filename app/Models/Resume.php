<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'slug',
        'status',
        'content_data',
        'settings',
        'original_file',
        'last_edited_at',
    ];

    protected $casts = [
        'content_data' => 'array',
        'settings' => 'array',
        'last_edited_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resume) {
            if (empty($resume->slug)) {
                $resume->slug = Str::slug($resume->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ResumeSection::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function getPersonalInfoAttribute()
    {
        return $this->content_data['personal_info'] ?? [];
    }

    public function getExperienceAttribute()
    {
        return $this->content_data['experience'] ?? [];
    }

    public function getEducationAttribute()
    {
        return $this->content_data['education'] ?? [];
    }

    public function getSkillsAttribute()
    {
        return $this->content_data['skills'] ?? [];
    }

    public function getProjectsAttribute()
    {
        return $this->content_data['projects'] ?? [];
    }

    public function getLanguagesAttribute()
    {
        return $this->content_data['languages'] ?? [];
    }

    public function getSummaryAttribute()
    {
        return $this->content_data['summary'] ?? '';
    }
}
