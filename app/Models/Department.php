<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'icon',
        'bg_color',
        'border_color',
        'border_main_color',
        'badge_color',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
