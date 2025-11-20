<?php

namespace App\Http\Controllers;

use App\Http\Requests\hotel\StoreHotelRequest;
use App\Http\Requests\hotel\UpdateHotelRequest;
use App\Http\Resources\HotelResource;
use App\Http\Resources\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class HotelController extends Controller
{
    protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $hotels = Hotel::with('rooms')->paginate(10);
        return HotelResource::collection($hotels);
    }

    public function show($id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return new HotelResource($hotel);
    }
    public function rooms(Request $request, $hotelId)
    {
        $perPage = $request->query('per_page', 10); // افتراضي 10
        $rooms = Room::where('hotel_id', $hotelId)->paginate($perPage);

        return RoomResource::collection($rooms);
    }

    public function store(StoreHotelRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }

        // تحويل location إلى POINT
        if (isset($validated['location']['lat'], $validated['location']['lng'])) {
            $lat = $validated['location']['lat'];
            $lng = $validated['location']['lng'];
            $validated['location'] = DB::raw("POINT($lat, $lng)");
        }

        // تحويل الحقول JSON
        foreach (['amenities', 'policies', 'contact_info'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        $hotel = $this->hotelService->create($validated->except(['hotel_image', 'hotel_gallery']));

        if ($request->hasFile('hotel_image')) {
            $hotel->attachSingleTo('hotel_image', 'hotel_image');
        }

        if ($request->hasFile('hotel_gallery')) {
            $hotel->attachMultipleTo('hotel_gallery', 'hotel_gallery');
        }
        return new HotelResource($hotel);
    }




    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $validated = $request->validated();

        // تحويل location لو موجود
        if (isset($validated['location']['lat'], $validated['location']['lng'])) {
            $lat = $validated['location']['lat'];
            $lng = $validated['location']['lng'];
            $validated['location'] = DB::raw("POINT($lat, $lng)");
        }

        // تحويل JSON fields لو موجودة
        foreach (['amenities', 'policies', 'contact_info'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        $hotel->update($validated->except(['hotel_image', 'hotel_gallery', 'delete_media'])); // تحديث جزئي فقط
        $deleteList = $request->input('delete_media', []);
        if (!empty($deleteList)) {
            foreach ($deleteList as $idOrUuid) {
                // حاول تستخدم HasMediaCollections::deleteMediaByUuid اذا موجود
                if (method_exists($hotel, 'deleteMediaByUuid')) {
                    $hotel->deleteMediaByUuid($idOrUuid);
                    continue;
                }

                // fallback: delete by id or uuid
                $media = $hotel->media()->where(function ($q) use ($idOrUuid) {
                    $q->where('id', $idOrUuid)->orWhere('uuid', $idOrUuid);
                })->first();

                if ($media) {
                    $media->delete();
                }
            }
        }

        // hotel_image (single)
        if ($request->hasFile('hotel_image')) {
            if (method_exists($hotel, 'attachSingleTo')) {
                $hotel->attachSingleTo('hotel_image', 'hotel_image');
            } elseif (method_exists($hotel, 'addMediaToCollection')) {
                $hotel->addMediaToCollection($request->file('hotel_image'), 'hotel_image');
            } else {
                $hotel->addMediaFromRequest('hotel_image')->toMediaCollection('hotel_image');
            }
        }

        // hotel_gallery (multiple)
        if ($request->hasFile('hotel_gallery')) {
            if (method_exists($hotel, 'attachMultipleTo')) {
                $hotel->attachMultipleTo('hotel_gallery', 'hotel_gallery');
            } elseif (method_exists($hotel, 'addMultipleMediaToCollection')) {
                $hotel->addMultipleMediaToCollection($request->file('hotel_gallery'), 'hotel_gallery');
            } else {
                foreach ($request->file('hotel_gallery') as $f) {
                    $hotel->addMedia($f)->toMediaCollection('hotel_gallery');
                }
            }
        }

        return new HotelResource($hotel->refresh());
    }



    public function destroy(Hotel $hotel)
    {
        $this->hotelService->delete($hotel);
        return response()->json(['success' => true, 'message' => 'Hotel deleted successfully']);
    }
    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        // إذا المستخدم لم يرسل إحداثيات
        if (!$lat || !$lng) {
            $hotels = $this->hotelService->nearby(null, null); // هيرجع كل الفنادق paginate
            return response()->json([
                'message' => 'Returning all hotels because no location is sent',
                'data' => HotelResource::collection($hotels)
            ]);
        }

        $hotels = $this->hotelService->nearby((float) $lat, (float) $lng, 100);

        return response()->json([
            'message' => 'Nearby hotels based on your location',
            'data' => HotelResource::collection($hotels)
        ]);
    }



}
