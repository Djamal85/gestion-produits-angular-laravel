<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transforme le modèle Eloquent en réponse JSON stable.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // Présent lorsque le contrôleur utilise withCount('products').
            'products_count' => $this->whenCounted('products'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
