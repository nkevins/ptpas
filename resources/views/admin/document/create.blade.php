@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Document</h1>
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
                        <form class="form-horizontal" action="{{action('DocumentController@save')}}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name <span style="color:red;">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{old('name')}}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="revision" class="col-sm-2 col-form-label">Revision</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="revision" name="revision" placeholder="Revision" value="{{old('revision')}}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file" class="col-sm-2 col-form-label">File <span style="color:red;">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file" required />
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="revision" class="col-sm-2 col-form-label">Remarks</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="3" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <a href="{{action('DocumentController@index')}}" class="btn btn-secondary">Cancel</a>
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

@push('scripts')
    <script type="text/javascript">
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
