<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'message'     => $this->message,
            'sender_type' => $this->sender_type,
            'attachments' => $this->attachments ?? [],
            'created_at'  => $this->created_at->toISOString(),
        ];
    }
}
