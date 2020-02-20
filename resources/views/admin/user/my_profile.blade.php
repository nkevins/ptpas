@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Profile</h1>
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
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3>User Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Name <span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext" id="name" name="name" readonly value="{{$user->name}}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username <span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext" id="username" name="username" readonly value="{{$user->username}}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control-plaintext" id="email" name="email" readonly value="{{$user->email}}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control-plaintext" id="role" name="role" readonly value="{{$roles}}" />
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-6">
                    <!-- Default box -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3>Change Password</h3>
                        </div>
                        <form class="form-horizontal" action="{{action('UserController@changeMyPassword')}}" method="POST">
                            <div class="card-body">
                                @include('flash::message')
                                @csrf
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">Password <span style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm Password <span style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <!-- Default box -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3>Change OTP Token</h3>
                        </div>
                        <form class="form-horizontal" action="{{action('UserController@changeMyOTPToken')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <p>Changing OTP Token will require user to reconfigure Google Authenticator.</p>
                                <p>This action will invalidate the previous secret key.</p>
                                <p>The new token will only be displayed ONE time after clicking the Change OTP Token button and not retrievable again.</p>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to change OTP Token?')">Change OTP Token</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@stop
