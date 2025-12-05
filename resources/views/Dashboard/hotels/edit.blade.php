@extends('dashboard.layouts.dashboard')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Edit Hotel</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="name">Name</label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name', $hotel->name) }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="slug">Slug</label>
                                    <input name="slug" type="text" class="form-control" value="{{ old('slug', $hotel->slug) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control">{{ old('description', $hotel->description) }}</textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">Address</label>
                                    <input name="address" type="text" class="form-control" value="{{ old('address', $hotel->address) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="amenities">Amenities (comma separated)</label>
                                    <input name="amenities" type="text" class="form-control"
                                        value="{{ old('amenities', implode(', ', $hotel->amenities ?? [])) }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="policies">Policies (comma separated)</label>
                                    <input name="policies" type="text" class="form-control"
                                        value="{{ old('policies', implode(', ', $hotel->policies ?? [])) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="phone">Phone</label>
                                    <input name="contact_info[phone]" type="text" class="form-control"
                                        value="{{ old('contact_info.phone', $hotel->contact_info['phone'] ?? '') }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">Email</label>
                                    <input name="contact_info[email]" type="email" class="form-control"
                                        value="{{ old('contact_info.email', $hotel->contact_info['email'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="lat">Latitude</label>
                                    <input name="location[lat]" type="text" class="form-control"
                                        value="{{ old('location.lat', $hotel->latitude) }}">
                                </div>
                                <div class="form-group col-6">
                                    <label for="lng">Longitude</label>
                                    <input name="location[lng]" type="text" class="form-control"
                                        value="{{ old('location.lng', $hotel->longitude) }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group col-6">
                                    <label for="hotel_image">Main Image</label>
                                    <input name="hotel_image" type="file" class="form-control">
                                    @if($hotel->getFirstMediaUrl('hotel_image'))
                                        <img src="{{ $hotel->getFirstMediaUrl('hotel_image') }}" width="150" class="mt-2">
                                    @endif
                                </div>

                                <div class="form-group col-6">
                                    <label for="hotel_gallery">Gallery Images</label>
                                    <input name="hotel_gallery[]" type="file" multiple class="form-control">
                                    @foreach($hotel->getMedia('hotel_gallery') as $media)
                                        <img src="{{ $media->getUrl() }}" width="100" class="mt-2 me-1">
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Hotel</button>
                            <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
