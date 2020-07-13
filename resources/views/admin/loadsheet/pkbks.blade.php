<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}" />
        
        <title>PK-BKS Loadsheet</title>
        
        <style type="text/css">
            .legendLayer .background {
                fill: rgba(255, 255, 255, 0.3);
                stroke: rgba(0, 0, 0, 0.85);
                stroke-width: 1;
            }
            
            @media print {
                .rows-print-as-pages .row {
                    page-break-before: always;
                }
                
                .rows-print-as-pages .row:first-child {
                    page-break-before: avoid;
                }
                
                .no-print, .no-print *
                {
                  display: none !important;
                }
            }
        </style>
    </head>
  <body>
	<h3 class="text-center">PT. Penerbangan Angkasa Semesta</h3>
	<h3 class="text-center">Cessna Citation 560XLS Loadsheet</h3>
    <h3 class="text-center">PK-BKS</h3>
    <hr />
	
    <div class="container rows-print-as-pages">
      <div class="row">

        <div class="col-md">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th colspan="5" class="text-center">CREW AND PAYLOAD COMPUTATIONS</th>
              </tr>
              <tr>
                <th class="text-center align-middle">ITEM</th>
                <th class="text-center align-middle">NAME</th>
                <th class="text-center align-middle">ARM<br/>(In.)</th>
                <th class="text-center align-middle">WEIGHT<br/>(lb.)</th>
                <th class="text-center align-middle">MOMENT/100<br/>(in-lb)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>OCCUPANTS</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Seat 1</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat1">
                    <option value="C">CRW</option>
                    <option value="P">PAX</option>
                  </select>
                </td>
                <td>136.32</td>
                <td><input type="number" id="W_PL_Seat1" value="0" /></td>
                <td id="CG_PL_Seat1">0</td>
              </tr>
              <tr>
                <td>Seat 2</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat2">
                    <option value="C">CRW</option>
                    <option value="P">PAX</option>
                  </select>
                </td>
                <td>136.32</td>
                <td><input type="number" id="W_PL_Seat2" value="0" /></td>
                <td id="CG_PL_Seat2">0</td>
              </tr>
              <tr>
                <td>Seat 10 Fwd</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat10F">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>181.24</td>
                <td><input type="number" id="W_PL_Seat10F" value="0" /></td>
                <td id="CG_PL_Seat10F">0</td>
              </tr>
              <tr>
                <td>Seat 10 Aft</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat10A">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>205.60</td>
                <td><input type="number" id="W_PL_Seat10A" value="0" /></td>
                <td id="CG_PL_Seat10A">0</td>
              </tr>
              <tr>
                <td>Seat 3</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat3">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>234.39</td>
                <td><input type="number" id="W_PL_Seat3" value="0" /></td>
                <td id="CG_PL_Seat3">0</td>
              </tr>
              <tr>
                <td>Seat 4</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat4">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>234.39</td>
                <td><input type="number" id="W_PL_Seat4" value="0" /></td>
                <td id="CG_PL_Seat4">0</td>
              </tr>
              <tr>
                <td>Seat 5</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat5">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>286.54</td>
                <td><input type="number" id="W_PL_Seat5" value="0" /></td>
                <td id="CG_PL_Seat5">0</td>
              </tr>
              <tr>
                <td>Seat 6</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat6">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>286.54</td>
                <td><input type="number" id="W_PL_Seat6" value="0" /></td>
                <td id="CG_PL_Seat6">0</td>
              </tr>
              <tr>
                <td>Seat 7</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat7">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>322.62</td>
                <td><input type="number" id="W_PL_Seat7" value="0" /></td>
                <td id="CG_PL_Seat7">0</td>
              </tr>
              <tr>
                <td>Seat 8</td>
                <td>
                  <input type="text" />
                  <select id="Type_Seat8">
                    <option value="P">PAX</option>
                    <option value="C">CRW</option>
                  </select>
                </td>
                <td>322.62</td>
                <td><input type="number" id="W_PL_Seat8" value="0" /></td>
                <td id="CG_PL_Seat8">0</td>
              </tr>
              <tr>
                <td>SFS</td>
                <td><input type="text" /></td>
                <td>357.99</td>
                <td><input type="number" id="W_PL_SFS" value="0" /></td>
                <td id="CG_PL_SFS">0</td>
              </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td>TCONE/CGO</td>
                <td><input type="text" /></td>
                <td>431.00</td>
                <td><input type="number" id="W_PL_CGO1" value="0" /></td>
                <td id="CG_PL_CGO1">0</td>
              </tr>
              <tr>
                <td></td>
                <td><input type="text" /></td>
                <td>157.99</td>
                <td><input type="number" id="W_PL_CGO2" value="0" /></td>
                <td id="CG_PL_CGO2">0</td>
              </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td>CHART CASES</td>
                <td><input type="text" /></td>
                <td>158.10</td>
                <td><input type="number" id="W_PL_CHRT1" value="0" /></td>
                <td id="CG_PL_CHRT1">0</td>
              </tr>
              <tr>
                <td></td>
                <td><input type="text" /></td>
                <td>166.22</td>
                <td><input type="number" id="W_PL_CHRT2" value="0" /></td>
                <td id="CG_PL_CHRT2">0</td>
              </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td>REFRESHMENT</td>
                <td><input type="text" /></td>
                <td>172.47</td>
                <td><input type="number" id="W_PL_REFRESHMENT" value="0" /></td>
                <td id="CG_PL_REFRESHMENT">0</td>
              </tr>
              <tr>
                <td>AFT TOILET</td>
                <td><input type="text" /></td>
                <td>357.99</td>
                <td><input type="number" id="W_PL_TOILET" value="0" /></td>
                <td id="CG_PL_TOILET">0</td>
              </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" class="font-weight-bold">CREW+PAYLOAD (SUB-TOTAL)</td>
                <td id="totalPayloadWeight" class="font-weight-bold">0</td>
                <td id="totalPayloadMoment" class="font-weight-bold">0</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th colspan="2" class="text-center align-middle">ITEM</th>
                <th class="text-center align-middle">WEIGHT<br/>(lb.)</th>
                <th class="text-center align-middle">MOMENT/100<br/>(in-lb)</th>
                <th class="text-center align-middle">LIMIT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>BASIC EMPTY WEIGHT</td>
                <td id="basicEmptyWeight">0</td>
                <td id="basicEmptyMoment">0</td>
                <td></td>
              </tr>
              <tr>
                <td>2</td>
                <td>PAYLOAD</td>
                <td id="payloadWeight">0</td>
                <td id="payloadMoment">0</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>ZERO FUEL WEIGHT</td>
                <td id="zfw" class="font-weight-bold">0</td>
                <td id="zfwMoment">0</td>
                <td id="mzfw"></td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4">AIRPLANE CG: <span id="zfwCg">0</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>BLOCK FUEL</td>
                <td><input type="number" id="blockFuel" value="100" /></td>
                <td id="blockFuelMoment">0</td>
                <td></td>
              </tr>
              <tr>
                <td>5</td>
                <td>RAMP WEIGHT</td>
                <td id="rampWeight">0</td>
                <td id="rampWeightMoment">0</td>
                <td id="maxRampWeight">0</td>
              </tr>
              <tr>
                <td>6</td>
                <td>TAXI FUEL</td>
                <td><input type="number" id="taxiFuel" value="200" /></td>
                <td id="taxiFuelMoment">0</td>
                <td></td>
              </tr>
              <tr>
                <td>7</td>
                <td>TAKEOFF WEIGHT</td>
                <td id="tow" class="font-weight-bold">0</td>
                <td id="towMoment">0</td>
                <td id="mtow"></td>
              </tr>
              <tr>
                <td></td>                
                <td colspan="4">
                  AIRPLANE CG: <span id="towCg">0</span>
                  <br />
                  <span id="towCgPercent" style="margin-left:80pt;"></span>
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>LESS FUEL TO DESTINATION</td>
                <td><input type="number" id="tripFuel" value="100" /></td>
                <td id="tripFuelMoment">0</td>
                <td></td>
              </tr>
              <tr>
                <td>9</td>
                <td>Landing Weight</td>
                <td id="law" class="font-weight-bold">0</td>
                <td id="lawMoment">0</td>
                <td id=mlw></td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4">AIRPLANE CG: <span id="lawCg">0</span></td>
              </tr>
            </tbody>
          </table>

          <!--Loadsheet Chart-->
          <div id="LoadsheetChart" style="width:700px;height:500px;margin:2px; background-color:#808080;">
          </div>
          
          <form action="{{action('LoadsheetController@pkbksPrint')}}" method="POST" class="no-print mt-3">
            @csrf
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" name="departure" placeholder="Departure" required />
              </div>
              <div class="col">
                <input type="text" class="form-control" name="destination" placeholder="Destination" required />
              </div>
            </div>
            <div class="form-row mt-1">
              <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                <input type="hidden" id="loadsheetData" name="loadsheetData" />    
              </div>
            </div>
          </form>
          
        </div>
      </div>
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
    <script type="text/javascript" src="{{asset('js/loadsheet/loadsheet_pkbks.js') }}"></script>
      
  </body>
</html>