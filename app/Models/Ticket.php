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
        'status_before_delete',
        'priority',
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

        static::deleting(function ($model) {
            // Keep original status before soft delete, then mark as closed.
            if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                return;
            }

            $model->status_before_delete = $model->status;
            $model->status = 'closed';
            $model->saveQuietly();
        });

        static::restored(function ($model) {
            if (!$model->status_before_delete) {
                return;
            }

            $model->status = $model->status_before_delete;
            $model->status_before_delete = null;
            $model->saveQuietly();
        });
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