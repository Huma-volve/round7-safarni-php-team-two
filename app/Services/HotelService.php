<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Pagination\LengthAwarePaginator;

class HotelService
{
    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function update(Hotel $hotel, array $data): Hotel
    {
        $hotel->update($data);
        return $hotel;
    }

    public function delete(Hotel $hotel): void
    {
        $hotel->delete();
    }

    /**
     * Get nearby hotels based on latitude & longitude.
     * @param float|null $lat
     * @param float|null $lng
     * @param int $radiusKm
     * @param int $perPage
     * @return LengthAwarePaginator
     */
public function nearby(?float $lat, ?float $lng, int $radiusKm = 10, int $perPage = 10)
{
    if (!$lat || !$lng) {
        return Hotel::with('rooms')->paginate($perPage);
    }

    $radiusInMeters = $radiusKm * 1000;

    return Hotel::selectRaw("
            *,
            ST_Distance_Sphere(location, POINT(?, ?)) AS distance
        ", [$lng, $lat])
        ->whereNotNull('location') // مهم
        ->whereRaw("ST_Distance_Sphere(location, POINT(?, ?)) <= ?", [$lng, $lat, $radiusInMeters])
        ->orderBy('distance')
        ->with('rooms')
        ->paginate($perPage);
}

}
