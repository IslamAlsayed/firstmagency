<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ar');
        $translations = $this->translations ?? [];
        $t = $translations[$lang] ?? $translations['ar'] ?? [];

        return [
            'id'          => $this->id,
            'slug'        => $this->slug,
            'title'       => $t['title'] ?? '',
            'description' => $t['description'] ?? '',
            'icon'        => $this->icon,
            'image'       => $this->image ? asset('storage/' . $this->image) : null,
            'status'      => $this->status,
            'order'       => $this->order,
        ];
    }
}
