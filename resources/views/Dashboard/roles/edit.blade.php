@extends('dashboard.layouts.dashboard')
{{-- @section('title', 'Dashboard - Questions') --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Roles</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('roles.update', $role->id) }}" method="post" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Edit Roles</h3>
                            </div>
                            <div class="card-body">
                                    <div class="form-group col-12">
                                        <label for="exampleInputName1">Name</label>
                                        <input name="name" type="text" class="form-control" id="exampleInputName1"
                                            value="{{ $role->name }}">
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
