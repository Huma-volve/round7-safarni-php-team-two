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
                        <form action="{{ route('admins.update',$admins->id) }}" method="post" autocomplete="off"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Edit Admin</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Name</label>
                                        <input name="name" type="text" class="form-control" id="exampleInputName1"
                                            value="{{ $admins->name }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Email</label>
                                        <input name="email" type="email" class="form-control" id="exampleInputName1" value="{{ $admins->email }}">
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Password</label>
                                        <input name="password" type="password" class="form-control" id="exampleInputName1">
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Image</label>
                                        <input name="image" type="file" class="form-control" id="exampleInputName1">
                                    </div>

                                    @if (Auth::user()->hasRole('Super Admin'))
                                        {{-- Check if the user being edited is not a Super Admin --}}
                                        @if (!$admins->hasRole('Super Admin'))
                                            <div class="form-group col-6">
                                                <label for="exampleInputName1">Roles</label>
                                                <select name="role" class="form-control" required oninvalid="this.setCustomValidity('@lang('site.required')')" oninput="setCustomValidity('')">
                                                    <option selected disabled>Choose Role</option>
                                                    @foreach (DB::table('roles')->where('name', '!=', 'Super Admin')->get() as $role)
                                                        <option value="{{ $role->id }}"
                                                            @if ($admins->hasRole($role->name)) selected @endif>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @else
                                        {{-- If the current authenticated user is not a Super Admin, hide the field --}}
                                    @endif

                                    <div class="form-group col-6">
                                        <label for="exampleInputName1">Active</label>
                                        <select name="is_active" class="form-control" id="exampleInputName1">
                                            <option disabled>Select Status</option>
                                            <option value="1"
                                            {{ old('is_active', $admins->is_active ?? '') == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                        {{ old('is_active', $admins->is_active ?? '') == 0 ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Edit</button>
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
