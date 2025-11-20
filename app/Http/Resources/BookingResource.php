<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
      return [
            'id' => $this->id,
            'room_id' => $this->item_id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
