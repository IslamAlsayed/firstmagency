<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HostingFeature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'translations',
        'image',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'translations' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Boot method to generate slug automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $translations = $model->translations ?? [];
                $title = $translations['en']['title'] ?? $translations['ar']['title'] ?? null;
                $slug = Str::slug($title ?? 'features-hosting-' . time());
                $model->slug = $slug;
            }
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
