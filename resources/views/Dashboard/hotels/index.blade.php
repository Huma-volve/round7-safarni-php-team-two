@extends('dashboard.layouts.dashboard')
@section('title', 'Hotels List')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Hotels</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('hotels.create') }}" class="btn btn-success">Add Hotel</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Main Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Address</th>
                            <th>Amenities</th>
                            <th>Policies</th>
                            <th>Gallery</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $index => $hotel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($hotel->getFirstMediaUrl('hotel_image'))
                                    <img src="{{ $hotel->getFirstMediaUrl('hotel_image', 'thumb_webp') }}" alt="{{ $hotel->name }}" style="width: 80px; height: auto;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->slug }}</td>
                            <td>{{ $hotel->address }}</td>
<td>{{ implode(', ', $hotel->amenities ?? []) }}</td>
<td>{{ implode(', ', $hotel->policies ?? []) }}</td>

<td>
    @if($hotel->getFirstMedia('hotel_image'))
<img src="{{ $hotel->getFirstMedia('hotel_image')->getUrl() }}" style="width: 50px; height: auto; margin-right: 3px;" alt="{{ $hotel->name }}">
    @else
        <span class="text-muted">No image</span>
    @endif
</td>
<!-- http://127.0.0.1:8000/Mens-Herringbone-Blazer-Brown01-600x764 -->


                            <td>
                                <a href="{{ route('hotels.rooms.index', $hotel->id) }}" class="btn btn-sm btn-primary">show</a>

                                <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $hotels->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
