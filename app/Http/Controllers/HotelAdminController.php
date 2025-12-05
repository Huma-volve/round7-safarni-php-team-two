<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\hotel\StoreHotelRequest;
use App\Http\Requests\hotel\UpdateHotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\HotelService;
use Illuminate\Support\Arr;


class HotelAdminController extends Controller
{
        protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }
    public function index()
    {
        $hotels = Hotel::paginate(20);
        return view('Dashboard.hotels.index',compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }
       public function create()
    {
        return view('Dashboard.hotels.create');
    }


 

public function store(StoreHotelRequest $request)
{
    $validated = $request->validated();
// dd($validated);
    // توليد slug لو فاضي
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
    }

    // تحويل location إلى POINT
    if (isset($validated['location']['lat'], $validated['location']['lng'])) {
        $lat = $validated['location']['lat'];
        $lng = $validated['location']['lng'];
        $validated['location'] = DB::raw("POINT($lat, $lng)");
    }

    // amenities و policies و contact_info لازم تكون array قبل JSON encode
foreach (['amenities', 'policies', 'contact_info'] as $field) {
    if (isset($validated[$field]) && is_string($validated[$field])) {
        $validated[$field] = array_map('trim', explode(',', $validated[$field]));
    }
}

    // استثناء الصور قبل create
 $hotelData = Arr::except($validated, ['hotel_image', 'hotel_gallery']);
$hotel = $this->hotelService->create($hotelData);

// رفع الصور بعد إنشاء الـ hotel
if ($request->hasFile('hotel_image') && $request->file('hotel_image')->isValid()) {
    $hotel->addMedia($request->file('hotel_image'))->toMediaCollection('hotel_image', 'public');
}

if ($request->hasFile('hotel_gallery')) {
    foreach ($request->file('hotel_gallery') as $file) {
        if ($file->isValid()) {
            $hotel->addMedia($file)->toMediaCollection('hotel_gallery', 'public');
        }
    }
}




 
$hotel->refresh(); // مهم جداً
return redirect()->route('hotels.create')->with('success', 'Hotel created successfully');


}





    public function edit(Hotel $hotel)
    {
        return view('Dashboard.hotels.edit', compact('hotel'));
    }
public function update(UpdateHotelRequest $request, Hotel $hotel)
{
    $validated = $request->validated();

    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
    }

    if (isset($validated['location']['lat'], $validated['location']['lng'])) {
        $lat = $validated['location']['lat'];
        $lng = $validated['location']['lng'];
        $validated['location'] = DB::raw("POINT($lat, $lng)");
    }

    foreach (['amenities', 'policies', 'contact_info'] as $field) {
        if (isset($validated[$field]) && is_string($validated[$field])) {
            $validated[$field] = array_map('trim', explode(',', $validated[$field]));
        }
    }

    $hotelData = Arr::except($validated, ['hotel_image', 'hotel_gallery']);
    $hotel->update($hotelData);

    // Main image: استبدال إذا تم رفع جديدة
    if ($request->hasFile('hotel_image') && $request->file('hotel_image')->isValid()) {
        $hotel->clearMediaCollection('hotel_image');
        $hotel->addMedia($request->file('hotel_image'))->toMediaCollection('hotel_image', 'public');
    }

    // Gallery images: إضافة جديدة بدون حذف القديم
    if ($request->hasFile('hotel_gallery')) {
        foreach ($request->file('hotel_gallery') as $file) {
            if ($file->isValid()) {
                $hotel->addMedia($file)->toMediaCollection('hotel_gallery', 'public');
            }
        }
    }

    $hotel->refresh();

    return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully');
}



public function destroy(Hotel $hotel)
{
    // حذف جميع ملفات media المرتبطة بالفندق
    $hotel->clearMediaCollection('hotel_image');
    $hotel->clearMediaCollection('hotel_gallery');

    // حذف الفندق نفسه
    $hotel->delete();

    return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully');
}
}
