<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OurProgramming extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'our_programmings';

    protected $fillable = [
        'slug',
        'image',
        'alt_text',
        'order',
        'is_active',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Boot method لإنشاء slug تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $slug = Str::slug($model->image ?? 'our-programming-' . time());
                $model->slug = $slug;
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
