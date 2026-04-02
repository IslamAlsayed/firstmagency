<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ar');

        return [
            'id'       => $this->id,
            'question' => $lang === 'en' ? ($this->question ?? $this->question_ar) : $this->question_ar,
            'answer'   => $lang === 'en' ? ($this->answer ?? $this->answer_ar) : $this->answer_ar,
            'category' => $this->category,
        ];
    }
}
