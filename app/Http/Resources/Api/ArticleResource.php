<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ar');
        $translations = $this->translations ?? [];
        $t = $translations[$lang] ?? $translations['ar'] ?? [];

        return [
            'id'               => $this->id,
            'slug'             => $this->slug,
            'title'            => $t['title'] ?? '',
            'description'      => $t['description'] ?? '',
            'content'          => $t['content'] ?? '',
            'keywords'         => $t['keywords'] ?? '',
            'meta_description' => $t['meta_description'] ?? '',
            'thumbnail'        => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'category'         => $this->whenLoaded('category', fn() => [
                'id'   => $this->category->id,
                'name' => is_array($this->category->translations)
                    ? ($this->category->translations[$lang]['name'] ?? $this->category->translations['ar']['name'] ?? '')
                    : $this->category->name ?? '',
            ]),
            'status'       => $this->status,
            'published_at' => $this->published_at?->toISOString(),
            'created_at'   => $this->created_at->toISOString(),
        ];
    }
}
