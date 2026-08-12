<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'preparation_time' => $this->preparation_time,
            'yield' => $this->yield,
            'category' => $this->category,
            'url_image' => $this->url_image,
            'user' => UserResource::make($this->whenLoaded('user')),
            'links' => [
                'self' => route('api.recipes.show', $this),
            ],
        ];
    }
}
