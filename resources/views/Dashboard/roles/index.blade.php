@extends('dashboard.layouts.dashboard')
@section('title', 'Dashboard -role')
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

    <div class="card">
        @if (auth('admins')->user()->hasPermissionTo('roles-create'))
            <a href="{{ route('roles.create') }}" class="btn btn-primary mt-4 mx-4 mb-4" style="width: 100px;">Add</a>
        @endif
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            @if (auth('admins')->user()->hasPermissionTo('roles-permission'))
                                <td><a class="dropdown-item" href="{{ route('getpermissions', $role->id) }}">
                                        <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                        permission</a></td>
                                <td>
                            @endif
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if (auth('admins')->user()->hasPermissionTo('roles-update'))
                                        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
                                            Edit</a>
                                    @endif
                                    @if (auth('admins')->user()->hasPermissionTo('roles-delete'))
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Are you sure you want to delete this role?');">
                                                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>




@endsection



@push('scripts')
@endpush
