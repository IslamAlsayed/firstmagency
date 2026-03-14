<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'subject',
        'department_id',
        'status',
        'priority',
        'user_id',
        'is_active',
        'assigned_to',
        'token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'attachments' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = mt_rand(100000000, 999999999);
            if (!$model->token) {
                $model->token = bin2hex(random_bytes(32));
            }
        });

        static::updating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = mt_rand(100000000, 999999999);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function ratings()
    {
        return $this->hasMany(TicketRating::class);
    }

    public function rating()
    {
        return $this->hasOne(TicketRating::class)->latest();
    }
}
