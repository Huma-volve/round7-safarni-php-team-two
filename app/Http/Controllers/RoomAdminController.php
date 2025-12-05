<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomAdminController extends Controller
{
    public function index(Hotel $hotel)
    {
        $rooms = $hotel->rooms()->paginate(10);
        return view('Dashboard.rooms.index', compact('hotel', 'rooms'));
    }

    public function create(Hotel $hotel)
    {
        return view('Dashboard.rooms.create', compact('hotel'));
    }

public function store(StoreRoomRequest $request, Hotel $hotel)
{
    // dd($request);
    $validated = $request->validated();

    $room = $hotel->rooms()->create($validated);

    // صورة أساسية
    if ($request->hasFile('main_image')) {
        $room->addMedia($request->file('main_image'))
             ->toMediaCollection('main_image');
    }

    // جاليري صور
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $file) {
            $room->addMedia($file)->toMediaCollection('photos');
        }
    }

    return redirect()->back()->with('success', 'Room Created');
}


    public function edit(Hotel $hotel, Room $room)
    {
        return view('Dashboard.rooms.edit', compact('hotel', 'room'));
    }

public function update(UpdateRoomRequest $request, Hotel $hotel, Room $room)
{
    $validated = $request->validated();

    // تحويل availability_calendar أو أي حقل string لقائمة
    foreach (['availability_calendar'] as $field) {
        if (isset($validated[$field]) && is_string($validated[$field])) {
            $validated[$field] = json_encode(explode(',', $validated[$field]));
        }
    }

    // التعامل مع main_image
    if ($request->hasFile('main_image')) {
        $room->clearMediaCollection('main_image'); // امسح القديمة
        $room->addMediaFromRequest('main_image')->toMediaCollection('main_image'); // أضف الجديدة
    }

    // التعامل مع gallery photos
    if ($request->hasFile('photos')) {
        $room->clearMediaCollection('photos'); // امسح كل الصور القديمة
        foreach ($request->file('photos') as $photo) {
            $room->addMedia($photo)->toMediaCollection('photos'); // أضف الجديدة
        }
    }

    // تحديث باقي البيانات
    $room->update($validated);

    return redirect()->route('hotels.rooms.index', $hotel->id)
                     ->with('success', 'Room updated successfully');
}
    public function destroy(Hotel $hotel, Room $room)
    {
        $room->delete();

        return redirect()->route('hotels.rooms.index', $hotel->id)
                         ->with('success', 'Room deleted successfully');
    }
}
