@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Aircraft</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <!-- Default box -->
                    <div class="card">
                        @include('flash::message')
                        <form class="form-horizontal" action="{{action('AircraftController@save')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="form-group row">
                                    <label for="registration" class="col-sm-2 col-form-label">Registration <span style="color:red;">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="registration" name="registration" placeholder="Registration" required />
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{action('AircraftController@index')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@stop
