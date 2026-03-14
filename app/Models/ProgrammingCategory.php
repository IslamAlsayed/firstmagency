<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgrammingCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'image',
        'alt_text',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Boot method لإنشاء slug تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function activeArticles()
    {
        return $this->articles()->published();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}