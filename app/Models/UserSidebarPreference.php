<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSidebarPreference extends Model
{
    protected $fillable = [
        'user_id',
        'menu_order',
        'submenu_order',
    ];

    protected $casts = [
        'menu_order' => 'array',
        'submenu_order' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
