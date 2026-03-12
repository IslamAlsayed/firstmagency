<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'question_ar',
        'answer',
        'answer_ar',
        'category',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Categories
    const CATEGORIES = [
        'websites' => 'Website Developer',
        'apps' => 'App Mobile',
        'domains' => 'Domains',
        'hosting' => 'Hosting',
        'services-marketing' => 'Services Marketing',
    ];

    public function scopeActive()
    {
        return $this->where('is_active', true);
    }

    public function scopeWebsites()
    {
        return $this->where('category', 'websites');
    }

    public function scopeApps()
    {
        return $this->where('category', 'apps');
    }

    public function scopeDomains()
    {
        return $this->where('category', 'domains');
    }

    public function scopeHosting()
    {
        return $this->where('category', 'hosting');
    }

    public function scopeServicesMarketing()
    {
        return $this->where('category', 'services-marketing');
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
