<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => $this->role,
            'photo'  => $this->photo ? asset('storage/' . $this->photo) : null,
            'mobile' => $this->mobile,
            'phone'  => $this->phone,
        ];
    }
}
