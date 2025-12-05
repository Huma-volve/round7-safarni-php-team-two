@extends('dashboard.layouts.dashboard')

@section('content')
<h1>Edit Room: {{ $room->name }} ({{ $hotel->name }})</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('hotels.rooms.update', [$hotel->id, $room->id]) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')


    <div class="mb-3">
        <label for="name" class="form-label">Room Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $room->name) }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $room->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="bed_number" class="form-label">Number of Beds</label>
        <input type="number" name="bed_number" id="bed_number" class="form-control" value="{{ old('bed_number', $room->bed_number) }}">
    </div>

    <div class="mb-3">
        <label for="room_area" class="form-label">Room Area (m²)</label>
        <input type="number" name="room_area" id="room_area" class="form-control" value="{{ old('room_area', $room->room_area) }}">
    </div>

    <div class="mb-3">
        <label for="price_per_night" class="form-label">Price per Night</label>
        <input type="number" step="0.01" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night', $room->price_per_night) }}">
    </div>

    <div class="mb-3">
        <label>Main Image</label><br>
        @if($room->getFirstMediaUrl('main_image'))
            <img src="{{ $room->getFirstMediaUrl('main_image') }}" width="120" class="mb-2"><br>
        @endif
        <input type="file" name="main_image" class="form-control">
        <small>Upload new image to replace existing one</small>
    </div>

    <div class="mb-3">
        <label>Gallery Photos</label><br>
        @if($room->getMedia('photos')->count())
            @foreach($room->getMedia('photos') as $photo)
                <img src="{{ $photo->getUrl() }}" width="80" class="me-1 mb-1">
            @endforeach
        @endif
        <input type="file" name="photos[]" class="form-control" multiple>
        <small>Upload new images to add to gallery</small>
    </div>

    <div class="mb-3">
        <label for="availability_calendar" class="form-label">Availability (comma separated dates)</label>
        <input type="text" name="availability_calendar" id="availability_calendar" class="form-control" value="{{ old('availability_calendar', implode(',', $room->availability_calendar ?? [])) }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Room</button>
</form>
@endsection
