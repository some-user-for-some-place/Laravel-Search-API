<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomesResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'bedrooms' => $this->bedrooms,
            'bathrooms'=>$this->bathrooms,
            'storeys'=>$this->storeys,
            'garages'=>$this->garages
        ];
    }
}
?>
