<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HostingPackage extends Model
{
    use SoftDeletes;

    protected $table = 'hosting_packages';
    protected $fillable = [
        'slug',
        'category',
        'translations',
        'monthly_price',
        'yearly_price',
        'features',
        'image',
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
    ];

    // Boot - Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $titleEn = $model->translations['en']['title'] ?? 'package';
                $baseSlug = Str::slug($titleEn, '-');
                $model->slug = $model->category . '-' . $baseSlug;
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $titleEn = $model->translations['en']['title'] ?? 'package';
                $baseSlug = Str::slug($titleEn, '-');
                $model->slug = $model->category . '-' . $baseSlug;
            }
        });
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

    // Scopes
    public function scopeHostingPackages($query)
    {
        return $query->where('category', 'hosting');
    }

    public function scopeResellerPackages($query)
    {
        return $query->where('category', 'reseller');
    }

    public function scopeVpsPackages($query)
    {
        return $query->where('category', 'vps');
    }

    public function scopeServerPackages($query)
    {
        return $query->where('category', 'servers');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
