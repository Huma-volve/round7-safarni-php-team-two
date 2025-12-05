@extends('dashboard.layouts.dashboard')

@section('content')
<h1>Add Room for {{ $hotel->name }}</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('hotels.rooms.store', $hotel->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Room Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="bed_number" class="form-label">Number of Beds</label>
        <input type="number" name="bed_number" id="bed_number" class="form-control" value="{{ old('bed_number') }}">
    </div>

    <div class="mb-3">
        <label for="room_area" class="form-label">Room Area (m²)</label>
        <input type="number" name="room_area" id="room_area" class="form-control" value="{{ old('room_area') }}">
    </div>

    <div class="mb-3">
        <label for="price_per_night" class="form-label">Price per Night</label>
        <input type="number" step="0.01" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night') }}">
    </div>

    <div class="mb-3">
        <label for="main_image" class="form-label">Main Image</label>
        <input type="file" name="main_image" id="main_image" class="form-control">
    </div>

    <div class="mb-3">
        <label for="photos" class="form-label">Gallery Photos</label>
        <input type="file" name="photos[]" id="photos" class="form-control" multiple>
    </div>

    <div class="mb-3">
        <label for="availability_calendar" class="form-label">Availability (comma separated dates)</label>
        <input type="text" name="availability_calendar" id="availability_calendar" class="form-control" value="{{ old('availability_calendar') }}">
    </div>

    <button type="submit" class="btn btn-primary">Add Room</button>
</form>
@endsection
