<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficialDomain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'translations',
        'website',
        'order',
        'status',
        'is_active',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected $casts = [
        'translations' => 'json',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot lifecycle
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $name = $model->translations['en']['name'] ?? 'official-domain';
                $model->slug = \Illuminate\Support\Str::slug($name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $name = $model->translations['en']['name'] ?? 'official-domain';
                $model->slug = \Illuminate\Support\Str::slug($name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
