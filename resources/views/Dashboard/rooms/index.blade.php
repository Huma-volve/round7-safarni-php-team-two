@extends('dashboard.layouts.dashboard')

@section('content')
<h1>Rooms for {{ $hotel->name }}</h1>
<a href="{{ route('hotels.rooms.create', $hotel->id) }}" class="btn btn-primary mb-2">Add Room</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Area</th>
            <th>Price/night</th>
            <th>Main Image</th>
            <th>Photos</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rooms as $room)
        <tr>
            <td>{{ $room->name }}</td>
            <td>{{ $room->room_area }} m²</td>
            <td>{{ $room->price_per_night }}</td>
        <td>
    @if($room->getFirstMediaUrl('main_image'))
        <img src="{{ $room->getFirstMediaUrl('main_image') }}" width="60">
    @endif
</td>

         <td>
    @foreach($room->getMedia('photos') as $media)
        <img src="{{ $media->getUrl() }}" width="50" class="me-1">
    @endforeach
</td>
            <td>
                <a href="{{ route('hotels.rooms.edit', [$hotel->id, $room->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('hotels.rooms.destroy', [$hotel->id, $room->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $rooms->links() }}
@endsection
