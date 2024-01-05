<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'long_url' => $this->whenNotNull($this->long_url),
            'short_url' => $this->whenNotNull($this->short_url),

        ];
    }
}
