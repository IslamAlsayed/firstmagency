<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgrammingSystem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'translations',
        'icon',
        'images',
        'alt_text',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'translations' => 'array',
        'images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Boot method لإنشاء slug تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug(str_replace(' ', '-', str_replace('_', '-', $model->translations['en']['name'] ?? 'programming-system-' . time()))) ?? 'programming-system-' . time();
            }
        });
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
