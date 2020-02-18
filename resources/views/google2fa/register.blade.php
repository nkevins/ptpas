@extends('admin/app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>OTP Setup</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <!-- Default box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3>Set up Google Authenticator</h3>
                        </div>
                        <div class="card-body">
                            @include('flash::message')
                            <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code <strong>{{ $secret }}</strong></p>
                            <div>
                                <img src="{{ $QR_Image }}">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{action('UserController@index')}}"><button class="btn btn-success">Complete</button></a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
        </div>
        
    </section>

@stop
