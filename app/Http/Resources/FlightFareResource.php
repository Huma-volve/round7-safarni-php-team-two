<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightFareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'flight_id'=>$this->flight_id,
            'seat_label'=>$this->seat_label,
            'class'=>$this->class,
            'is_available'=>$this->is_available
        ];
    }
}
