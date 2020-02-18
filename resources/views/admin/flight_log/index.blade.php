@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Flight Log</h1>
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
                            <a href="{{action('FlightLogController@create')}}" class="btn btn-primary">Add</a>
                        </div>
                        <div class="card-body">
                            @include('flash::message')
                            <div class="table-responsive">
                                <table id="flightLogTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="4" style="text-align:center;">Route</th>
                                            <th colspan="3" style="text-align:center;">Block</th>
                                            <th colspan="4" style="text-align:center;">Crew</th>
                                            <th colspan="3"></th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. Tech Log</th>
                                            <th>Aircraft</th>
                                            <th>FROM</th>
                                            <th>TO</th>
                                            <th>Route</th>
                                            <th>OFF</th>
                                            <th>ON</th>
                                            <th>TIME</th>
                                            <th>PIC</th>
                                            <th>SIC</th>
                                            <th>EOB1</th>
                                            <th>EOB2</th>
                                            <th>PAX</th>
                                            <th>RMK</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
            $("#flightLogTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! action('FlightLogController@flightLogData') !!}',
                order: [[0, 'desc']],
                language: {
                    emptyTable: 'No Flight Log Record'
                },
                columns: [
                    { data: 'date' },
                    { data: 'techlog' },
                    { data: 'aircraft.registration' },
                    { data: 'departure.name' },
                    { data: 'destination.name' },
                    { data: 'route' },
                    { data: 'off_time' },
                    { data: 'on_time' },
                    { data: 'block_time' },
                    { data: 'pic.name' },
                    { data: 'sic' },
                    { data: 'eob1' },
                    { data: 'eob2' },
                    { data: 'pax' },
                    { data: 'remarks' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function (data, type, full, meta) {
                            return moment(data).format("D/M/YYYY");
                        }
                    },
                    {
                        targets: 6,
                        render: function (data, type, full, meta) {
                            return moment(data, "HH:mm:ss").format("HH:mm");
                        }
                    },
                    {
                        targets: 7,
                        render: function (data, type, full, meta) {
                            return moment(data, "HH:mm:ss").format("HH:mm");
                        }
                    },
                    {
                        targets: 8,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return moment.utc(moment.duration(parseInt(data), "minutes").asMilliseconds()).format("HH:mm");
                        }
                    },
                    {
                        targets: 10,
                        render: function (data, type, full, meta) {
                            if (data)
                                return data.name;
                            else
                                return '';
                        }
                    },
                    {
                        targets: 15,
                        data: null,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<a href="flight_log/' + data['id'] + '/edit" class="btn btn-primary btn-sm mr-2" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>' +
                                '<form action="flight_log/remove" method="POST" style="display: inline;">' +
                                '{!! csrf_field() !!}' +
                                '<input type="hidden" name="id" value="' + data['id'] + '" />' +
                                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Confirm Log deletion?\')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>' +
                                '</form>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
