<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>PK-BKS Loadsheet</title>
        
        <style type="text/css">
            .legendLayer .background {
                fill: rgba(255, 255, 255, 0.3);
                stroke: rgba(0, 0, 0, 0.85);
                stroke-width: 1;
            }
            
            .print-break {
                page-break-before: always;
            }
            
            pre {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
    </head>
  <body>
      <pre>
                         PT. PENERBANGAN ANGKASA SEMESTA
          
          
L O A D S H E E T              ISSUED BY        APPROVED      DATE         TIME
                                                              {{strtoupper(date('d M Y'))}}  {{gmdate('Hi')}}Z
ALL WEIGHTS IN POUNDS          .........       ..........

                                                           
FROM/TO    A/C REG      A/C TYPE             
{{$departure}}/{{$destination}}  PK-BKS       C560XLS/PW545B                  

                         WEIGHT
LOAD IN TCONE/CGO     {{str_pad($data->cargoWeight, 9, ' ', STR_PAD_LEFT)}}     

CREW WEIGHT           {{str_pad($data->crewWeight, 9, ' ', STR_PAD_LEFT)}}
PASSENGER WEIGHT      {{str_pad($data->paxWeight, 9, ' ', STR_PAD_LEFT)}}
TTL {{$data->totalPob}}

TOTAL PAYLOAD             {{str_pad($data->payload, 5, ' ', STR_PAD_LEFT)}}
BASIC OPERATING WEIGHT    {{str_pad($data->bow, 5, ' ', STR_PAD_LEFT)}}
ZERO FUEL WEIGHT ACTUAL   {{str_pad($data->zfw, 5, ' ', STR_PAD_LEFT)}}   MAX    15100 {{$underweightLimit == 'ZFW' ? 'L' : ''}}
TAKE OFF FUEL             {{str_pad($data->toFuel, 5, ' ', STR_PAD_LEFT)}}
TAKE OFF WEIGHT  ACTUAL   {{str_pad($data->tow, 5, ' ', STR_PAD_LEFT)}}   MAX    20400 {{$underweightLimit == 'TOW' ? 'L' : ''}}
TRIP FUEL                 {{str_pad($data->tripFuel, 5, ' ', STR_PAD_LEFT)}}
LANDING WEIGHT   ACTUAL   {{str_pad($data->law, 5, ' ', STR_PAD_LEFT)}}   MAX    20200 {{$underweightLimit == 'LAW' ? 'L' : ''}}
TAXI OUT FUEL             {{str_pad($data->taxiFuel, 5, ' ', STR_PAD_LEFT)}}

UNDERLOAD BEFORE L.M.C.    {{str_pad($underweightValue, 4, ' ', STR_PAD_RIGHT)}}   LIMITED BY {{$underweightLimit}}            LMC TOTAL  + / -

BALANCING/TRIM CONDITIONS
MACZFW  {{$data->zfwCgPercent}}%
MACTOW  {{$data->towCgPercent}}%   
MACLDW  {{$data->lawCgPercent}}%

MAC LIMITS
ZFW   FWD {{number_format($maclimitfwd['ZFW'], 3, '.', '')}}%   AFT {{number_format($maclimitaft['ZFW'], 3, '.', '')}}%
TOW   FWD {{number_format($maclimitfwd['TOW'], 3, '.', '')}}%   AFT {{number_format($maclimitaft['TOW'], 3, '.', '')}}%
LDW   FWD {{number_format($maclimitfwd['LAW'], 3, '.', '')}}%   AFT {{number_format($maclimitaft['LAW'], 3, '.', '')}}%

TRIM BY CABIN AREA
{{$data->occupancy}}.

CAPTAINS INFORMATION/NOTES
STD WEIGHTS USED  ADULT/180 CHILD/77 INFANT/22
BLOCK FUEL/   {{str_pad($data->fuelWeight, 4, ' ', STR_PAD_LEFT)}} 
LANDG FUEL/   {{str_pad($data->landingFuel, 4, ' ', STR_PAD_LEFT)}} 

TAXI TIME 10 MIN

CREATED WITH PASYS    {{strtoupper(date('dMY'))}} {{gmdate('Hi')}}Z

END LOADSHEET PK-BKS {{$departure}}/{{$destination}}
      </pre>
      
      <!--Loadsheet Chart-->
      <div id="LoadsheetChart" style="width:700px;height:500px;margin:2px; background-color:#808080;" class="print-break">
      </div>
      
        <!-- Optional JavaScript -->
        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/lib/jquery.event.drag.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/lib/jquery.mousewheel.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.canvaswrapper.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.colorhelpers.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.dashes.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.axislabels.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.saturated.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.browser.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.drawSeries.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.uiConstants.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.navigate.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.resize.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.symbol.js') }}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('plugins/flot-loadsheet/source/jquery.flot.legend.js') }}"></script>
        
        <script type="text/javascript">
        $(document).ready(function () {
            // Loadsheet chart option
            var options = {
                legend: {
                    position: 'ne',
                    show: false,
                    noColumns: 2,
                    labelFormatter: function(label, series) {
                        if (label == 'Envelope' || label == 'CGLine' || label == 'MRW' || label == 'MZFW' || label == 'MLW')
                            return null;
                        else
                            return label;
                    }
                },
                series: {
                    legend: { show: true },
                    lines: { show: true, lineWidth: 1 },
                    points: { radius: 5 } 
                },
                zoom: {
                    interactive: true
                },
                pan: {
                    interactive: true
                },
            	yaxis: {
            		ticks: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
            		min: 10,
            		max: 21,
            		axisLabel: "WEIGHT (POUNDS x 1000)"
            	},
            	xaxes: [
            	    {
            	        ticks: [316, 317, 318, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332, 333, 334],
            	        min: 316,
            	        max: 334,
            	        tickFormatter: function (val, axis) {
                                if (val % 2 == 0)
                                    return val;
                                else
                                    return '';
                            },
                        axisLabel: "CENTER OF GRAVITY (INCHES x 100)"
            	    },
            	    {
            	        ticks: [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33],
            	        min: 11.45056726,
            	        max: 33.33063209,
            	        tickFormatter: function (val, axis) {
                                if (val % 2 == 0)
                                    return val;
                                else
                                    return '';
                            },
                        axisLabel: "CENTER OF GRAVITY - PERCENT MAC"
            	    }
        	    ]
            };

            let envelope = {
                label: "Envelope",
                data: [[318.92, 10],[318.92, 11.5],[324.29, 20.4],[330.74, 20.4],[330.74, 17.8],
                    [331.26,15.1],[331.26,10],[318.92, 10]],
                color: "#0000ff",
            };
            let maxTowLine = {
                label: "MTOW",
                data: [[316, 20.2], [334, 20.2]],
                lines: { show: false },
                dashes: { show: true },
                color: "#000000",
                shadowSize: 0
            };
            let maxLawLine = {
                label: "MLW",
                data: [[316, 18.7], [334, 18.7]],
                lines: { show: false },
                dashes: { show: true },
                color: "#000000",
                shadowSize: 0
            };
            let maxZfwLine = {
                label: "MZFW",
                data: [[316, 15.1], [334, 15.1]],
                lines: { show: false },
                dashes: { show: true },
                color: "#000000",
                shadowSize: 0
            };
            let cgLine = {
                label: "CGLine",
                data: [[11.45056726, 10], [33.33063209, 10]],
                lines: { show: false }, 
                points: { show: false },
                xaxis: 2    
            };
            
            var ZFWPoint = { label: "ZFW", points: { show: true }, data: [[0, 0]] };
            var TOWPoint = { label: "TOW", points: { show: true }, data: [[0, 0]], color: '#ff0000' };
            var LWPoint = { label: "L/W", points: { show: true }, data: [[0, 0]] };
        
            // Draw chart
            ZFWPoint.data[0][0] = {{$data->zfwCg}};
            ZFWPoint.data[0][1] = {{$data->zfw}} / 1000;
            
            TOWPoint.data[0][0] = {{$data->towCg}};
            TOWPoint.data[0][1] = {{$data->tow}} / 1000;
        
            LWPoint.data[0][0] = {{$data->lawCg}};
            LWPoint.data[0][1] = {{$data->law}} / 1000;
            
            var placeholder = $("#LoadsheetChart");
            
            var plot = $.plot(placeholder, [envelope, ZFWPoint, TOWPoint, LWPoint, maxTowLine,
                maxLawLine, maxZfwLine, cgLine], options);
                
                
            // Limitation line label
            var o = plot.pointOffset({ x: 318, y: 15.6});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:smaller'>MZFW 15,100</div>");
            
            o = plot.pointOffset({ x: 318, y: 19.2});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:smaller'>MLW 18,700</div>");
            
            o = plot.pointOffset({ x: 318, y: 20.7});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:smaller'>MTW 20,200</div>");
            
            // ZFW Label
            o = plot.pointOffset({ x: ZFWPoint.data[0][0], y: ZFWPoint.data[0][1]});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 10) + "px;top:" + (o.top - 7) + "px;color:#000;font-size:smaller'>ZFW</div>");
            
            // TOW Label
            o = plot.pointOffset({ x: TOWPoint.data[0][0], y: TOWPoint.data[0][1]});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 10) + "px;top:" + (o.top - 7) + "px;color:#000;font-size:smaller'>TOW</div>");
            
            // LAW Label
            o = plot.pointOffset({ x: LWPoint.data[0][0], y: LWPoint.data[0][1]});
            placeholder.append("<div style='position:absolute;left:" + (o.left + 10) + "px;top:" + (o.top - 7) + "px;color:#000;font-size:smaller'>L/W</div>");
                
            window.onresize = function (event) {
                $.plot($("#LoadsheetChart"), [envelope, ZFWPoint, TOWPoint, LWPoint, maxTowLine,
                    maxLawLine, maxZfwLine, cgLine], options);
            }
        });
        </script>
  </body>
</html>