<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'image'      => $this->image ? asset('storage/' . $this->image) : null,
            'tags'       => $this->tags ?? [],
            'order'      => $this->order,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
