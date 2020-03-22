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
                                            <th colspan="4"></th>
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
                                            <th>Purpose</th>
                                            <th>RMK</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="modal fade" id="modal-flightMap">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="fligtMapTitle"></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="flightMap" style="height: 700px;"></div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
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
        var flightLogTable = null;
        
        $(function () {
            flightLogTable = $("#flightLogTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! action('FlightLogController@flightLogData') !!}',
                order: [[0, 'desc'], [6, 'asc']],
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
                    { data: 'purpose' },
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
                        targets: 16,
                        data: null,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<button class="btn btn-info btn-sm mr-2" data-toggle="tooltip" title="Map" id="showMapButton"><i class="fas fa-map-marked-alt"></i></button>' +
                                '<a href="flight_log/' + data['id'] + '/edit" class="btn btn-primary btn-sm mr-2" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>' +
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
        
        var flightMap;
        var markersGroup;
        // Function to pop up map
        $('#flightLogTable tbody').on('click', '#showMapButton', function () {
            var data = flightLogTable.row($(this).parents('tr')).data();
            
            $('#fligtMapTitle').text(moment(data.date).format("D/M/YYYY") + ' ' + data.aircraft.registration + ' (' + data.departure.name + ' - ' + data.destination.name + ')');
            
            // Map Rendering
            var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            	attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });
            
            var streetLayer = L.tileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                subdomains: ['a','b','c']
            })
            
            if (flightMap != undefined) { flightMap.remove(); } 
            flightMap = L.map('flightMap', {
                            center: [3.6422, 98.88527],
                            zoom: 13,
                            layers: [satelliteLayer, streetLayer]
                        });
            
            // Layer selection    
            var baseMaps = {
                    "Streets": streetLayer,
                    "Satellite": satelliteLayer
                };
            L.control.layers(baseMaps).addTo(flightMap);
            
            // Route drawing
            const departure = {lat: parseInt(data.departure.lat), lng: parseInt(data.departure.lon)};
            const destination = {lat: parseInt(data.destination.lat), lng: parseInt(data.destination.lon)};
            const geodesic = new L.Geodesic([departure, destination]).addTo(flightMap);
            
            var departureMarker = L.marker([parseInt(data.departure.lat), parseInt(data.departure.lon)]);
            departureMarker.bindPopup(data.departure.name);
            var destinationMarker = L.marker([parseInt(data.destination.lat), parseInt(data.destination.lon)]);
            destinationMarker.bindPopup(data.destination.name);
            var markers = [
                departureMarker,
                destinationMarker
            ];
            
            markersGroup = L.featureGroup(markers).addTo(flightMap);
            
            $('#modal-flightMap').modal();
        });
        
        $('#modal-flightMap').on('show.bs.modal', function() {
            setTimeout(function() {
                flightMap.invalidateSize();
                flightMap.fitBounds(markersGroup.getBounds());
            }, 200);
        });
    </script>
@endpush
