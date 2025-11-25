@extends('dashboard.layouts.dashboard')
{{-- @section('title', 'Dashboard - Questions') --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admins.store') }}" method="post" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Add Admin</h3>
                            </div>
                            <div class="card-body">
                                <div class="row m-2">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Name</label>
                                        <input name="name" type="text" class="form-control" id="exampleInputName1"
                                            value="{{ old('name') }}" placeholder="Add Name">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Email</label>
                                        <input name="email" type="email" class="form-control" id="exampleInputName1"
                                            placeholder="Add Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="row m-2">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Password</label>
                                        <input name="password" type="password" class="form-control" id="exampleInputName1"
                                            placeholder="Add Password" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Image</label>
                                        <input name="image" type="file" class="form-control" id="exampleInputName1"
                                            placeholder="Add Image" value="{{ old('image') }}">
                                    </div>
                                </div>
                                <div class="row m-2">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Role</label>
                                        <select name="role" class="form-control" required
                                            oninvalid="this.setCustomValidity('@lang('site.required')')"
                                            oninput="setCustomValidity('')">
                                            <option selected disabled>Choose Role</option>
                                            @foreach (DB::table('roles')->where('name', '!=', 'Super Admin')->get() as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Active</label>
                                        <select name="is_active" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection






@push('scripts')
@endpush
