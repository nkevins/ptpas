@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Flight Log</h1>
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
                        @include('flash::message')
                        <form class="form-horizontal" action="{{action('FlightLogController@save')}}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 col-form-label">Date <span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="date" name="date" required value="{{old('date')}}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="techLogNo" class="col-sm-2 col-form-label">No. Tech Log <span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="techLogNo" name="techLogNo" required value="{{old('techLogNo')}}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Aircraft</label>
                                            <select class="col-sm-10 form-control" name="aircraft" required>
                                                @foreach ($aircrafts as $a)
                                                    <option value="{{$a->id}}" @if (old('aircraft') == $a->id) selected @endif>{{$a->registration}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">From</label>
                                            <select class="col-sm-10 form-control" name="from" required>
                                                @foreach ($airports as $a)
                                                    <option value="{{$a->id}}" @if (old('from') == $a->id) selected @endif>{{$a->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">To</label>
                                            <select class="col-sm-10 form-control" name="to" required>
                                                @foreach ($airports as $a)
                                                    <option value="{{$a->id}}" @if (old('to') == $a->id) selected @endif>{{$a->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="blockOff" class="col-sm-2 col-form-label">Block Off <span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="blockOff" name="blockOff" data-inputmask="'mask': '99:99'" data-mask required required value="{{old('blockOff')}}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="blockOn" class="col-sm-2 col-form-label">Block On <span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="blockOn" name="blockOn" data-inputmask="'mask': '99:99'" data-mask required required value="{{old('blockOn')}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">PIC</label>
                                            <select class="col-sm-10 form-control" name="pic" required>
                                                @foreach ($pilots as $p)
                                                    <option value="{{$p->id}}" @if (old('pic') == $p->id) selected @endif>{{$p->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">SIC</label>
                                            <select class="col-sm-10 form-control" name="sic" required>
                                                @foreach ($pilots as $p)
                                                    <option value="{{$p->id}}" @if (old('sic') == $p->id) selected @endif>{{$p->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="eob1" class="col-sm-2 col-form-label">EOB1</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" name="eob1" id="eob1">{{old('eob1')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="eob2" class="col-sm-2 col-form-label">EOB2</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" name="eob2" id="eob2">{{old('eob2')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pax" class="col-sm-2 col-form-label">PAX</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" name="pax" id="pax">{{old('pax')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="remarks" class="col-sm-2 col-form-label">RMK</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{action('FlightLogController@index')}}" class="btn btn-secondary">Cancel</a>
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
            $('#date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });
    </script>
@endpush
