<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketRating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'rating',
        'comment',
        'email',
        'token',
        'rated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'rated_at' => 'datetime',
    ];

    /**
     * العلاقة مع Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * إنشاء token فريد للتقييم
     */
    public static function generateToken()
    {
        do {
            $token = bin2hex(random_bytes(32));
        } while (self::where('token', $token)->exists());

        return $token;
    }
}
