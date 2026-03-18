<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhyUs extends Model
{
    use SoftDeletes;

    protected $table = 'why_us';

    protected $fillable = [
        'slug',
        'translations',
        'image',
        'alt_text',
        'order',
        'status',
        'is_active',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected $casts = [
        'translations' => AsCollection::class,
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Boot lifecycle
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $name = $model->translations['en']['name'] ?? 'why-us-item';
                $model->slug = \Illuminate\Support\Str::slug($name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $name = $model->translations['en']['name'] ?? 'why-us-item';
                $model->slug = \Illuminate\Support\Str::slug($name);
            }
        });
    }
}
