<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'country',
        'rate',
        'comment',
        'photo',
        'audio',
        'status',
    ];

    protected $casts = [
        'rate' => 'integer',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getAudioUrlAttribute()
    {
        return $this->audio ? asset('storage/' . $this->audio) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
