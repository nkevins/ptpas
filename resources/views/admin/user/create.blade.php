@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create User</h1>
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
                        <form class="form-horizontal" action="{{action('UserController@save')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Name <span style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{old('name')}}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-3 col-form-label">Username <span style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required value="{{old('username')}}" />
                                    </div>
                                </div>
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
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Roles <span style="color:red;">*</span></label>
                                    <div class="col-sm-10">
                                        @foreach ($roles as $r)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="role{{$r->id}}" name="roles[]" value="{{$r->id}}" />
                                                <label class="form-check-label" for="role{{$r->id}}">{{$r->name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{action('UserController@index')}}" class="btn btn-secondary">Cancel</a>
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
