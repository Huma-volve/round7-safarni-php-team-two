@extends('dashboard.layouts.dashboard')
@section('title', 'Dashboard -Admin')
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

    <div class="card">
        @if (auth('admins')->user()->hasPermissionTo('admins-create'))
            <a href="{{ route('admins.create') }}" class="btn btn-primary mt-4 mx-4 mb-4" style="width: 100px;">Add</a>
        @endif
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Logo</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->roles->last()->name ?? null }}</td>
                            <td><img src="{{ url($admin->image) }}" alt="Logo" style="width: 50px; height: 50px;"></td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up">
                                        @if ($admin->is_active == 1)
                                            <span class="badge bg-label-success me-1">Active</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">Inactive</span>
                                        @endif
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (auth('admins')->user()->hasPermissionTo('admins-update'))
                                            <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}">
                                                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                                Edit</a>
                                        @endif
                                        @if (auth('admins')->user()->hasPermissionTo('admins-delete'))
                                            <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Are you sure you want to delete this admin?');">
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
