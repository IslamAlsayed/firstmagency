<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class DashboardsAndSystem extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $table = 'dashboards_and_systems';

    protected $fillable = [
        'slug',
        'type',
        'translations',
        'image',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'translations' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Generate slug from translated title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $title = $model->translations['en']['title'] ?? $model->translations['ar']['title'] ?? 'dashboard-system';
                $model->slug = \Illuminate\Support\Str::slug($title);
            }
        });

        static::updating(function ($model) {
            if (!$model->slug) {
                $title = $model->translations['en']['title'] ?? $model->translations['ar']['title'] ?? 'dashboard-system';
                $model->slug = \Illuminate\Support\Str::slug($title);
            }
        });
    }

    /**
     * Get the user who created this record
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this record
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for operating systems
     */
    public function scopeOperatingSystems($query)
    {
        return $query->where('type', 'operating-system');
    }

    /**
     * Scope for dashboards and apps
     */
    public function scopeDashboardsApps($query)
    {
        return $query->where('type', 'dashboard-app');
    }
}
