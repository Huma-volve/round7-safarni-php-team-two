@extends('dashboard.layouts.dashboard')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Hotel</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('hotels.store') }}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Hotel Details</h3>
                            </div>
                            <div class="card-body">
                                <!-- Basic Info -->
                                <div class="row mb-2">
                                    <div class="form-group col-6">
                                        <label for="name">Hotel Name</label>
    <input type="text" name="name" placeholder="Hotel Name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="slug">Slug</label>
                                        <input name="slug" type="text" class="form-control" id="slug" value="{{ old('slug') }}">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="form-group col-12">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="form-group col-6">
                                        <label for="address">Address</label>
                                        <input name="address" type="text" class="form-control" id="address" value="{{ old('address') }}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="image">Main Image</label>
                                        <input name="hotel_image"type="file" class="form-control" >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="image">Images</label>
                                        <input name="hotel_gallery[]" multiple type="file" class="form-control" >
                                    </div>
                                </div>

                           
                            <label for="amenities">Amenities</label>
<select name="amenities[]" multiple class="form-control">
    <option value="wifi" {{ in_array('wifi', old('amenities', [])) ? 'selected' : '' }}>WiFi</option>
    <option value="parking" {{ in_array('parking', old('amenities', [])) ? 'selected' : '' }}>Parking</option>
    <option value="pool" {{ in_array('pool', old('amenities', [])) ? 'selected' : '' }}>Pool</option>
</select>

<label for="policies">Policies</label>
<select name="policies[]" multiple class="form-control">
    <option value="check_in:14:00" {{ in_array('check_in:14:00', old('policies', [])) ? 'selected' : '' }}>Check In 14:00</option>
    <option value="check_out:12:00" {{ in_array('check_out:12:00', old('policies', [])) ? 'selected' : '' }}>Check Out 12:00</option>
    <option value="Free cancellation within 24h" {{ in_array('Free cancellation within 24h', old('policies', [])) ? 'selected' : '' }}>Free cancellation</option>
</select>


                                <!-- Contact Info -->
                                <div class="row mb-2">
                                    <div class="form-group col-6">
                                        <label for="phone">Phone</label>
                                        <input name="contact_info[phone]" type="text" class="form-control" id="phone" value="{{ old('contact_info.phone') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input name="contact_info[email]" type="email" class="form-control" id="email" value="{{ old('contact_info.email') }}">
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="row mb-2">
                                    <div class="form-group col-6">
                                        <label for="lat">Latitude</label>
                                        <input name="location[lat]" type="text" class="form-control" id="lat" value="{{ old('location.lat') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lng">Longitude</label>
                                        <input name="location[lng]" type="text" class="form-control" id="lng" value="{{ old('location.lng') }}">
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Hotel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


     <!-- Amenities -->