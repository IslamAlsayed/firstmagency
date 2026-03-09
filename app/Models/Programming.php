<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Programming extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'image',
        'alt_text',
        'order',
        'status',
        'is_active',
        'is_featured',
        'created_by',
        'updated_by',
        'published_at',
        'translations',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'translations' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Boot method لإنشاء slug تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $title = $model->translations['ar']['name'] ?? $model->translations['en']['name'] ?? 'programming';
                $model->slug = Str::slug($title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
