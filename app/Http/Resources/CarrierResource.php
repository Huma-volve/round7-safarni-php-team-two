<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarrierResource extends JsonResource
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
            'carrier_name' => $this->name,
            'carrier_code' => $this->code,
            'logo' => $this->logo_url,
            'is_active' => $this->is_active ?? true, // نفترض وجود حقل لتفعيل/تعطيل الشركة
            'details_link' => route('carrier.show', $this->id),
        ];
    }
}
