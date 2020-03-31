@extends('admin/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#reportTab" role="tab" aria-controls="reportTab" aria-selected="true">Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#flightLogTab" role="tab" aria-controls="flightLogTab" aria-selected="false">Flight Logs</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="reportTab" role="tabpanel" aria-labelledby="reportTab">
                                    
                                    <div class="row">
                                    	<div class="col-12">
                                    		<!-- Default box -->
                                    		<div class="card">
                                    			<div class="card-body">
                                    				<form class="form-inline">
                                    					<label class="my-1 mr-2" for="fromDate">From Date</label>
                                    					<input type="text" class="my-1 mr-sm-2" id="fromDate" name="fromDate" />
                                    					
                                    					<label class="my-1 mr-2" for="toDate">To Date</label>
                                    					<input type="text" class="my-1 mr-sm-2" id="toDate" name="toDate" />
                                    					
                                    					<button type="button" class="btn btn-primary my-1" onclick="search();">Search</button>
                                    				</form>
                                    			</div>
                                    			<!-- ./card-body -->
                                    		</div>
                                    		<!-- /.card -->
                                    	</div>
                                    </div>
                                    
                                    <!-- Small boxes (Stat box) -->
                                    <div class="row">
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h3 id="totalFlightsSummary">0</h3>
                                                    <p>Total Flights</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-plane"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3 id="totalHoursSummary">00:00</h3>
                                                    <p>Total Time</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-clock"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                    </div>
                                    
                                    <div class="row">
                                    	<div class="col-4">
                                    		<div class="card card-secondary">
                                    			<div class="card-header">
                                    				<h3 class="card-title">Total Flights</h3>
                                    			</div>
                                    			<div class="card-body">
                                    			    <select class="form-control" onchange="searchTotalFlights()" id="totalFlightsPurposeSelection">
                                    			        <option value="">All</option>
                                    			        <option value="Maintenance">Maintenance</option>
                                    			        <option value="Operation">Operation</option>
                                    			        <option value="Group">Group</option>
                                    			        <option value="Charter External">Charter External</option>
                                    			        <option value="Charter Internal">Charter Internal</option>
                                    			    </select>
                                    			    <div class="spinner-border" id="totalFlightChartLoading"></div>
                                    				<canvas id="totalFlightChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    			</div>
                                    			<!-- /.card-body -->
                                    		</div>
                                    		<!-- /.card -->
                                    	</div>
                                    	<div class="col-4">
                                    		<div class="card card-secondary">
                                    			<div class="card-header">
                                    				<h3 class="card-title">Total Time</h3>
                                    			</div>
                                    			<div class="card-body">
                                    			    <select class="form-control" onchange="searchTotalTime()" id="totalTimePurposeSelection">
                                    			        <option value="">All</option>
                                    			        <option value="Maintenance">Maintenance</option>
                                    			        <option value="Operation">Operation</option>
                                    			        <option value="Group">Group</option>
                                    			        <option value="Charter External">Charter External</option>
                                    			        <option value="Charter Internal">Charter Internal</option>
                                    			    </select>
                                    			    <div class="spinner-border" id="totalTimeChartLoading"></div>
                                    				<canvas id="totalTimeChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    			</div>
                                    			<!-- /.card-body -->
                                    		</div>
                                    		<!-- /.card -->
                                    	</div>
                                    	<div class="col-4">
                                    		<div class="card card-secondary">
                                    			<div class="card-header">
                                    				<h3 class="card-title">Total Crew Hours</h3>
                                    			</div>
                                    			<div class="card-body">
                                    			    <div class="spinner-border" id="totalCrewHoursChartLoading"></div>
                                    				<canvas id="totalCrewHoursChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    			</div>
                                    			<!-- /.card-body -->
                                    		</div>
                                    		<!-- /.card -->
                                    	</div>
                                    </div>
                                    
                                    <div class="row">
                                    	<div class="col-4">
                                    		<div class="card card-secondary">
                                    			<div class="card-header">
                                    				<h3 class="card-title">Crew Hours Per Aircraft</h3>
                                    			</div>
                                    			<div class="card-body">
                                    			    <select class="form-control" onchange="searchCrewHoursPerAircraft()" id="crewHourPilotSelection">
                                    			        <option value=""></option>
                                    			        @foreach ($pilots as $p)
                                    			        <option value="{{$p->id}}">{{$p->name}}</option>
                                    			        @endforeach
                                    			    </select>
                                    			    <div class="spinner-border mt-2" id="crewHoursPerAircraftChartLoading" style="display:none;"></div>
                                    				<canvas id="crewHoursPerAircraftChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    			</div>
                                    			<!-- /.card-body -->
                                    		</div>
                                    		<!-- /.card -->
                                    	</div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="flightLogTab" role="tabpanel" aria-labelledby="flightLogTab">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
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
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
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
        
        var totalFlightChart = null;
        var totalFlightHoursChart = null;
        var crewHoursChart = null;
        var crewHoursPerAircraftChart = null;
        
        $(function () {
            $('#fromDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('#toDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            
            const startOfMonth = moment().startOf('year').format('DD/MM/YYYY');
            const endOfMonth   = moment().endOf('year').format('DD/MM/YYYY');
            
            $('#fromDate').val(startOfMonth);
            $('#toDate').val(endOfMonth);
            
            search();
        });
        
        function pad(num, size) {
            var s = num+"";
            while (s.length < size) s = "0" + s;
            return s;
        }
        
        function search()
        {   
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            
            searchTotalFlights();
            searchTotalTime()
            
            // Show loading spinner
            $("#totalCrewHoursChartLoading").show();
            
            $.getJSON('/admin/dashboard/data/crewHours?from_date=' + fromDate + '&to_date=' + toDate, function(result) {
                $("#totalCrewHoursChartLoading").hide();
                
                var name = new Array();
                var totalHours = new Array();
                
                result.forEach(function(data){
                    name.push(data.name);
                    totalHours.push(data.hours);
                });
                
                var crewHoursChartCanvas = $('#totalCrewHoursChart').get(0).getContext('2d')
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                    // get the data label and data value to display
                                    // convert the data value to local string so it uses a comma seperated number
                                    var dataLabel = data.labels[tooltipItem.index];
                                    
                                    var totalTimeInMin = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    
                                    var value = ': ' + pad(Math.floor(totalTimeInMin / 60), 2) + ':' + pad(totalTimeInMin % 60, 2);
                                    
                                    // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                                    if (Chart.helpers.isArray(dataLabel)) {
                                        // show value on first line of multiline label
                                        // need to clone because we are changing the value
                                        dataLabel = dataLabel.slice();
                                        dataLabel[0] += value;
                                    } else {
                                        dataLabel += value;
                                    }
                                    
                                    // return the text to display on the tooltip
                                    return dataLabel;
                            }
                        }
                    }
                }
                
                if (crewHoursChart)
                    crewHoursChart.destroy();
                
                crewHoursChart = new Chart(crewHoursChartCanvas, {
                    type: 'pie',
                    data: {
                      labels: name,
                        datasets: [{
                            data: totalHours,
                            backgroundColor: palette('tol', totalHours.length).map(function(hex) {
                                                return '#' + hex;
                                             })
                        }]
                    },
                    options: pieOptions      
                })
            });
            
            searchCrewHoursPerAircraft();
        }
        
        $("#flightLogTable").DataTable({
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
            ]
        });
        
        function searchTotalFlights()
        {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var purpose = $('#totalFlightsPurposeSelection').val();
            
            $("#totalFlightChartLoading").show();
            
            $.getJSON('/admin/dashboard/data/totalFlights?from_date=' + fromDate + '&to_date=' + toDate + '&purpose=' + purpose, function(result) {
                $("#totalFlightChartLoading").hide();
                
                var aircrafts = new Array();
                var totalFlightsCount = new Array();
                var totalFlights = 0;
                
                result.forEach(function(data){
                    aircrafts.push(data.registration);
                    totalFlightsCount.push(data.flight_count);
                    totalFlights += parseInt(data.flight_count);
                });
                
                // Populate summary statistic
                $('#totalFlightsSummary').text(totalFlights);
                
                var totalFlightChartCanvas = $('#totalFlightChart').get(0).getContext('2d')
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                }
                
                if (totalFlightChart)
                    totalFlightChart.destroy();
                
                totalFlightChart = new Chart(totalFlightChartCanvas, {
                    type: 'pie',
                    data: {
                      labels: aircrafts,
                        datasets: [{
                            data: totalFlightsCount,
                            backgroundColor: palette('tol', totalFlightsCount.length).map(function(hex) {
                                                return '#' + hex;
                                             })
                        }]
                    },
                    options: pieOptions      
                })
            });
        }
        
        function searchTotalTime()
        {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var purpose = $('#totalTimePurposeSelection').val();
            
            $("#totalTimeChartLoading").show();
            
            $.getJSON('/admin/dashboard/data/flightHours?from_date=' + fromDate + '&to_date=' + toDate + '&purpose=' + purpose, function(result) {
                $("#totalTimeChartLoading").hide();
                
                var aircrafts = new Array();
                var totalHours = new Array();
                var totalHoursInMinutes = 0;
                
                result.forEach(function(data){
                    aircrafts.push(data.registration);
                    totalHours.push(data.block_time);
                    totalHoursInMinutes += parseInt(data.block_time);
                });
                
                // Populate summary statistic
                $('#totalHoursSummary').text(pad(Math.floor(totalHoursInMinutes / 60), 2) + ':' + pad(totalHoursInMinutes % 60, 2));
                
                var totalFlightHoursChartCanvas = $('#totalTimeChart').get(0).getContext('2d')
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                    // get the data label and data value to display
                                    // convert the data value to local string so it uses a comma seperated number
                                    var dataLabel = data.labels[tooltipItem.index];
                                    
                                    var totalTimeInMin = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    
                                    var value = ': ' + pad(Math.floor(totalTimeInMin / 60), 2) + ':' + pad(totalTimeInMin % 60, 2);
                                    
                                    // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                                    if (Chart.helpers.isArray(dataLabel)) {
                                        // show value on first line of multiline label
                                        // need to clone because we are changing the value
                                        dataLabel = dataLabel.slice();
                                        dataLabel[0] += value;
                                    } else {
                                        dataLabel += value;
                                    }
                                    
                                    // return the text to display on the tooltip
                                    return dataLabel;
                            }
                        }
                    }
                }
                
                if (totalFlightHoursChart)
                    totalFlightHoursChart.destroy();
                
                totalFlightHoursChart = new Chart(totalFlightHoursChartCanvas, {
                    type: 'pie',
                    data: {
                      labels: aircrafts,
                        datasets: [{
                            data: totalHours,
                            backgroundColor: palette('tol', totalHours.length).map(function(hex) {
                                                return '#' + hex;
                                             })
                        }]
                    },
                    options: pieOptions      
                })
            });
        }
        
        function searchCrewHoursPerAircraft()
        {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var pilot = $('#crewHourPilotSelection').val();
            
            if (pilot === '') {
                if (crewHoursPerAircraftChart)
                    crewHoursPerAircraftChart.destroy();
                return;
            }
            
            $("#crewHoursPerAircraftChartLoading").show();
            
            $.getJSON('/admin/dashboard/data/crewHoursPerAircraft?from_date=' + fromDate + '&to_date=' + toDate + '&pilot_id=' + pilot, function(result) {
                $("#crewHoursPerAircraftChartLoading").hide();
                
                var aircrafts = new Array();
                var totalHours = new Array();
                
                result.forEach(function(data){
                    aircrafts.push(data.registration);
                    totalHours.push(data.block_time);
                });
                
                var crewHoursPerAircraftChartCanvas = $('#crewHoursPerAircraftChart').get(0).getContext('2d')
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                    // get the data label and data value to display
                                    // convert the data value to local string so it uses a comma seperated number
                                    var dataLabel = data.labels[tooltipItem.index];
                                    
                                    var totalTimeInMin = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    
                                    var value = ': ' + pad(Math.floor(totalTimeInMin / 60), 2) + ':' + pad(totalTimeInMin % 60, 2);
                                    
                                    // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                                    if (Chart.helpers.isArray(dataLabel)) {
                                        // show value on first line of multiline label
                                        // need to clone because we are changing the value
                                        dataLabel = dataLabel.slice();
                                        dataLabel[0] += value;
                                    } else {
                                        dataLabel += value;
                                    }
                                    
                                    // return the text to display on the tooltip
                                    return dataLabel;
                            }
                        }
                    }
                }
                
                if (crewHoursPerAircraftChart)
                    crewHoursPerAircraftChart.destroy();
                
                crewHoursPerAircraftChart = new Chart(crewHoursPerAircraftChartCanvas, {
                    type: 'pie',
                    data: {
                      labels: aircrafts,
                        datasets: [{
                            data: totalHours,
                            backgroundColor: palette('tol', totalHours.length).map(function(hex) {
                                                return '#' + hex;
                                             })
                        }]
                    },
                    options: pieOptions      
                })
            });
        }
    </script>
@endpush
