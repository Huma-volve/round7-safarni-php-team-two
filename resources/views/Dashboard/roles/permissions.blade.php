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

<style> 
     .per {
            display: flex;
            align-items: center;
            /* margin: 10px; */
            padding: 10px 25px;
            background-color: rgb(198, 195, 195, 0.2);
            border-radius: 10px;
            /* width: 25%; */
            color: #000;

        }

        .permission {
            height: 30px;
            width: 20px;
            margin: 0 6px;
                color: #000;
           
        }

        .style {
            display: flex;
            align-items: center;
            color: #000;

        }
        .card-body{
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap:10px;
                color: #000;

        }
        @media (
         max-width:768px
        ){
            .card-body{
                grid-template-columns: repeat(1,1fr);
            }
        }
</style>

     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('updategetpermissions', $id) }}" method="post" autocomplete="off"
                            enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">Add Permissions</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                {{-- <div class="row"> --}}
                                @foreach ($permissions as $permission)
                                    <div class="form-group per">
                                        <div class="style">
                                            <input name="permission[]" type="checkbox" class="permission"
                                                id="exampleInputName1" value="{{ $permission->id }}"
                                                @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                                <label for="exampleInputName1"> {{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- </div> --}}
                                <hr>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Save</button>
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
    <!-- /.content -->


@endsection
