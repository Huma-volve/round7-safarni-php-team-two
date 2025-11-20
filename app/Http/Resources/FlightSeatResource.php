<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightSeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
          'flight'=>$this->whenLoaded('flights'),
          'seat-label'=>$this->seat_label,
          'class'=>$this->class,
          'is-available'=>$this->is_available,
      ];
    }
}
