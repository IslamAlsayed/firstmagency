<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MarketingPackage extends Model
{
    use SoftDeletes;

    protected $table = 'marketing_packages';

    protected $fillable = [
        'slug',
        'category',
        'translations',
        'monthly_price',
        'yearly_price',
        'features',
        'image',
        'alt_text',
        'order',
        'is_popular',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'translations' => 'json',
        'features' => 'json',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
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

        static::creating(function ($model) {
            if (!$model->slug) {
                $titleEn = $model->translations['en']['title'] ?? $model->translations['ar']['title'] ?? 'package';
                $model->slug = Str::slug($titleEn);
            }
        });

        static::updating(function ($model) {
            if (!$model->slug) {
                $titleEn = $model->translations['en']['title'] ?? $model->translations['ar']['title'] ?? 'package';
                $model->slug = Str::slug($titleEn);
            }
        });
    }
}
