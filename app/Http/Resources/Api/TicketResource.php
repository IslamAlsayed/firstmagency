<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid'       => $this->uuid,
            'token'      => $this->token,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'subject'    => $this->subject,
            'status'     => $this->status,
            'priority'   => $this->priority,
            'department' => $this->whenLoaded('department', fn() => [
                'id'   => $this->department->id,
            ]),
            'messages'   => TicketMessageResource::collection($this->whenLoaded('messages')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
