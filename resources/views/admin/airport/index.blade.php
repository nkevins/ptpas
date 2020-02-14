@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Airports</h1>
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
                            <a href="{{action('AirportController@create')}}" class="btn btn-primary">Add</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('flash::message')
                            <table id="airportTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($airports as $ap)
                                    <tr>
                                        <td>{{$ap->name}}</td>
                                        <td>
                                            @if ($ap->active)
                                                <span class="badge badge-success">Y</span>
                                            @else
                                                <span class="badge badge-danger">N</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{action('AirportController@edit', $ap->id)}}" class="btn btn-primary float-left mr-1">Edit</a>
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
            $("#airportTable").DataTable();
        });
    </script>
@endpush
