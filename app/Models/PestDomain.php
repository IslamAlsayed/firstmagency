<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\SoftDeletes;

class PestDomain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'image',
        'alt_text',
        'price',
        'old_price',
        'discount_percentage',
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
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'published_at' => 'datetime',
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
                $model->slug = \Illuminate\Support\Str::slug('pest-domain');
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug('pest-domain');
            }
        });
    }

    /**
     * حساب old_price تلقائياً من price و discount_percentage
     * old_price = price / (1 - discount_percentage/100)
     */
    public function setDiscountPercentageAttribute($value)
    {
        $this->attributes['discount_percentage'] = $value;

        // حساب old_price تلقائياً إذا كان لدينا price و discount_percentage
        if (!empty($this->attributes['price']) && !empty($value) && $value > 0) {
            $this->attributes['old_price'] = round(
                $this->attributes['price'] / (1 - $value / 100),
                2
            );
        } else {
            // إذا لم يكن هناك خصم، old_price = price
            $this->attributes['old_price'] = $this->attributes['price'] ?? null;
        }
    }

    /**
     * عند تعيين price، أعيد حساب old_price
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value;

        // إعادة حساب old_price إذا كان هناك discount_percentage
        if (!empty($this->attributes['discount_percentage']) && $this->attributes['discount_percentage'] > 0) {
            $this->attributes['old_price'] = round(
                $value / (1 - $this->attributes['discount_percentage'] / 100),
                2
            );
        } else {
            $this->attributes['old_price'] = $value;
        }
    }

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
}
