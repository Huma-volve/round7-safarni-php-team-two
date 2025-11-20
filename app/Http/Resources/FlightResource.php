<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
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
            'flight_number' => $this->flight_number,
            'status' => $this->status->label(), // (0: Cancelled, 1: Scheduled, 2: Delayed)
            'carrier' => new CarrierResource($this->whenLoaded('carriers')),
            'original airport' => new AirportResource($this->whenLoaded('original_airport')),
            'destination' => new AirportResource($this->whenLoaded('dest_airport')),
            'departure_time' => $this->departure_at->format('Y-m-d H:i'),
            'arrival_time' => $this->arrival_at->format('Y-m-d H:i'),
            'duration' => $this->duration,

            //'fares' => FlightFareResource::collection($this->whenLoaded('fares')),
            ];
    }
}
