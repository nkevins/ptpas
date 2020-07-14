@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Documents</h1>
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
                        @if (Auth::user()->hasRole('Admin'))
                        <div class="card-header">
                            <a href="{{action('DocumentController@create')}}" class="btn btn-primary">Add</a>
                        </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('flash::message')
                            <table id="documentTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Revision</th>
                                        <th>Remarks</th>
                                        <th>Last Update</th>
                                        @if (Auth::user()->hasRole('Admin'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $d)
                                    <tr>
                                        <td><a href="{{action('DocumentController@download', $d->hash)}}">{{$d->name}}</a></td>
                                        <td>{{$d->revision}}</td>
                                        <td>{{$d->remarks}}</td>
                                        <td>{{$d->updated_at}}</td>
                                        @if (Auth::user()->hasRole('Admin'))
                                        <td>
                                            <a href="{{action('DocumentController@edit', $d->id)}}" class="btn btn-primary float-left mr-1">Edit</a>
                                            <form action="{{action('DocumentController@delete')}}" method="POST" onsubmit="return confirm('Do you really want to remove the document?');">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                <input type="hidden" name="documentId" value="{{$d->id}}" />
                                            </form>
                                        </td>
                                        @endif
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
            var table = $("#documentTable").DataTable();
            table.order([3, 'desc']).draw();
        });
    </script>
@endpush
