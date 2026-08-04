<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'quantite' => $this->quantite,
            'emplacement' => $this->emplacement,
            'price' => $this->price_cdf,
            'date_expiration' => $this->date_expiration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
