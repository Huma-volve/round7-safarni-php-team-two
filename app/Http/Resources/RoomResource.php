<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'description' => $this->description,
            'photos' => $this->photos ? json_decode($this->photos) : [],
            'main_image' => $this->main_image,
            'bed_number' => $this->bed_number, //bead type 
            'room_area' => $this->room_area,
            'price_per_night' => $this->price_per_night,
            'availability_calendar' => $this->availability_calendar ? json_decode($this->availability_calendar) : [],
        ];
    }
}
