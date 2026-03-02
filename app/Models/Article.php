<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'image',
        'thumbnail',
        'category_id',
        'visitors',
        'view_count',
        'likes_count',
        'comments_count',
        'status',
        'is_active',
        'featured',
        'related_articles',
        'created_by',
        'updated_by',
        'published_at',
        'translations',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'related_articles' => 'array',
        'translations' => 'array',
    ];

    // Boot method لإنشاء slug تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $title = $model->translations['ar']['title'] ?? $model->translations['en']['title'] ?? 'article';
                $model->slug = Str::slug($title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('translations') && !$model->isDirty('slug')) {
                $title = $model->translations['ar']['title'] ?? $model->translations['en']['title'] ?? 'article';
                $model->slug = Str::slug($title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors & Mutators
    public function getExcerptAttribute()
    {
        $description = $this->translations['ar']['description'] ?? $this->translations['en']['description'] ?? '';
        return Str::limit($description, 150);
    }

    public function getTitleAttribute($value = null)
    {
        $locale = app()->getLocale();
        return $this->translations[$locale]['title'] ?? '';
    }

    public function getRelatedArticlesListAttribute()
    {
        if (!$this->related_articles) {
            return [];
        }

        return Article::whereIn('id', $this->related_articles)->get();
    }
}
