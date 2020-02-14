@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <a href="{{action('UserController@create')}}" class="btn btn-primary">Add</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('flash::message')
                            <table id="userTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Roles</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                    <tr>
                                        <td>{{$u->name}}</td>
                                        <td>{{$u->username}}</td>
                                        <td>{{$u->roles->pluck('name')->implode(', ')}}</td>
                                        <td>
                                            @if ($u->active)
                                                <span class="badge badge-success">Y</span>
                                            @else
                                                <span class="badge badge-danger">N</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{action('UserController@edit', $u->id)}}" class="btn btn-primary float-left mr-1">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@stop

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $("#userTable").DataTable();
        });
    </script>
@endpush
