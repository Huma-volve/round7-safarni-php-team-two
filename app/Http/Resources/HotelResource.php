<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'images' => $this->image,
            'amenities' => $this->amenities ? json_decode($this->amenities) : [],

            'rating' => $this->rating,
            'policies' => $this->policies ? json_decode($this->policies) : [],

            'contact_info' => $this->contact_info ? json_decode($this->contact_info) : [],

            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
        ];
    }
}
