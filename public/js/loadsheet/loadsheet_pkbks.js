class PayloadStation {
    name = "";
    arm = 0.0;
    weight = 0.0;

    constructor(name, arm)
    {
        this.name = name;
        this.arm = arm;      
    }

    getMoment()
    {
        return this.arm * this.weight / 100.0;
    }

    setWeight(weight)
    {
        this.weight = weight;
    }
}

class Aircraft {
    // List of payload stations
    stations = new Map();
    totalPayloadWeight = 0.0;
    totalPayloadMoment = 0.0;

    // Aircraft weight data
    basicEmptyWeight = 0.0;
    basicEmptyWeightMoment = 0.0;

    fuelCgData = null;
    fuelWeight = 0.0;
    fuelMoment = 0.0;

    taxiFuelWeight = 0.0;
    taxiFuelMoment = 0.0;

    tripFuelWeight = 0.0;
    tripFuelMoment = 0.0;

    // Limitation
    maxRampWeight = 0.0;
    mtow = 0.0;
    mlw = 0.0;
    mzfw = 0.0;

    constructor(basicEmptyWeight, basicEmptyWeightMoment, fuelCgData, maxRampWeight,
        mtow, mlw, mzfw)
    {
        this.basicEmptyWeight = basicEmptyWeight;
        this.basicEmptyWeightMoment = basicEmptyWeightMoment;
        this.fuelCgData = fuelCgData;
        this.maxRampWeight = maxRampWeight;
        this.mtow = mtow;
        this.mlw = mlw;
        this.mzfw = mzfw;
    }

    addStation(name, arm)
    {
        this.stations.set(name, new PayloadStation(name, arm));
    }

    setStationWeight(name, weight)
    {
        var station = this.stations.get(name);
        station.setWeight(weight);

        // Recalculate total weight
        this.totalPayloadWeight = 0.0;
        for (const entry of this.stations.entries())
        {
            this.totalPayloadWeight += entry[1].weight;
        }

        // Recalculate total moment
        this.totalPayloadMoment = 0.0;
        for (const entry of this.stations.entries())
        {
            this.totalPayloadMoment += entry[1].getMoment();
        }
    }

    getZfw()
    {
        return this.basicEmptyWeight + this.totalPayloadWeight;
    }

    getZfwMoment()
    {
        return this.basicEmptyWeightMoment + this.totalPayloadMoment;
    }

    getZfwCg()
    {
        var zfwMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment;
        var zfw = this.basicEmptyWeight + this.totalPayloadWeight;
        return (zfwMoment / zfw * 100);
    }
    
    getZfwCgPercent()
    {
        var zfwMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment;
        var zfw = this.basicEmptyWeight + this.totalPayloadWeight;
        var zfwCg = zfwMoment / zfw * 100;
        return (zfwCg - 306.59) / 0.8223;
    }

    setFuelWeight(fuelWeight)
    {
        var i;
        for (i = 0; i < this.fuelCgData.length; i++)
        {
            if (this.fuelCgData[i][0] == fuelWeight)
            {
                this.fuelWeight = fuelWeight;
                this.fuelMoment = this.fuelCgData[i][1];                
                return true;
            }
            else if (fuelWeight < this.fuelCgData[i][0])
            {
                // Interpolate
                this.fuelWeight = fuelWeight;

                let upperMoment = this.fuelCgData[i][1];
                let lowerMoment = this.fuelCgData[i-1][1];
                let deltaMoment = upperMoment - lowerMoment;

                let upperWeight = this.fuelCgData[i][0];
                let lowerWeight = this.fuelCgData[i-1][0];
                
                let deltaWeight = fuelWeight - lowerWeight;

                this.fuelMoment = lowerMoment + (deltaWeight / (upperWeight - lowerWeight) * deltaMoment);

                return true;
            }
        }

        return false;
    }

    getRampWeight()
    {
        return this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight;
    }

    getRampWeightMoment()
    {
        return this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment;
    }

    setTaxiFuelWeight(fuelWeight)
    {
        var i;
        for (i = 0; i < this.fuelCgData.length; i++)
        {
            if (this.fuelCgData[i][0] == fuelWeight)
            {
                this.taxiFuelWeight = fuelWeight;
                this.taxiFuelMoment = this.fuelCgData[i][1];                
                return true;
            }
            else if (fuelWeight < this.fuelCgData[i][0])
            {
                // Interpolate
                this.taxiFuelWeight = fuelWeight;

                let upperMoment = this.fuelCgData[i][1];
                let lowerMoment = this.fuelCgData[i-1][1];
                let deltaMoment = upperMoment - lowerMoment;                

                let upperWeight = this.fuelCgData[i][0];
                let lowerWeight = this.fuelCgData[i-1][0];                
                
                let deltaWeight = fuelWeight - lowerWeight;

                this.taxiFuelMoment = lowerMoment + (deltaWeight / (upperWeight - lowerWeight) * deltaMoment);

                return true;
            }
        }

        return false;
    }

    getTow()
    {
        return this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - this.taxiFuelWeight;
    }

    getTowMoment()
    {
        return this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - this.taxiFuelMoment;
    }

    getTowCg()
    {
        var tow = this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - this.taxiFuelWeight;
        var towMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - this.taxiFuelMoment;
        return (towMoment / tow * 100);
    }

    getTowCgPercent()
    {
        var tow = this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - this.taxiFuelWeight;
        var towMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - this.taxiFuelMoment;
        var towCg = towMoment / tow * 100;
        return (towCg - 306.59) / 0.8223;
    }

    setTripFuelWeight(fuelWeight)
    {
        var i;
        for (i = 0; i < this.fuelCgData.length; i++)
        {
            if (this.fuelCgData[i][0] == fuelWeight)
            {
                this.tripFuelWeight = fuelWeight;
                this.tripFuelMoment = this.fuelCgData[i][1];                
                return true;
            }
            else if (fuelWeight < this.fuelCgData[i][0])
            {
                // Interpolate
                this.tripFuelWeight = fuelWeight;

                let upperMoment = this.fuelCgData[i][1];
                let lowerMoment = this.fuelCgData[i-1][1];
                let deltaMoment = upperMoment - lowerMoment;

                let upperWeight = this.fuelCgData[i][0];
                let lowerWeight = this.fuelCgData[i-1][0];
                
                let deltaWeight = fuelWeight - lowerWeight;

                this.tripFuelMoment = lowerMoment + (deltaWeight / (upperWeight - lowerWeight) * deltaMoment);

                return true;
            }
        }

        return false;
    }

    getLaw()
    {
        return this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - 
            this.taxiFuelWeight - this.tripFuelWeight;
    }

    getLawMoment()
    {
        return this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - 
            this.taxiFuelMoment - this.tripFuelMoment;
    }

    getLawCg()
    {
        var law = this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - 
            this.taxiFuelWeight - this.tripFuelWeight;
        var lawMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - 
            this.taxiFuelMoment - this.tripFuelMoment;
        return (lawMoment / law * 100);
    }
    
    getLawCgPercent()
    {
        var law = this.basicEmptyWeight + this.totalPayloadWeight + this.fuelWeight - 
            this.taxiFuelWeight - this.tripFuelWeight;
        var lawMoment = this.basicEmptyWeightMoment + this.totalPayloadMoment + this.fuelMoment - 
            this.taxiFuelMoment - this.tripFuelMoment;
        var lawCg = lawMoment / law * 100;
        return (lawCg - 306.59) / 0.8223;
    }
}

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
	xaxis: {
	    ticks: [316, 317, 318, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332, 333, 334],
        min: 316,
        max: 334,
        axisLabel: "CENTER OF GRAVITY (INCHES x 100)",
        tickFormatter: function (val, axis) {
                            if (val % 2 == 0)
                                return val;
                            else
                                return '';
                        }
	}
};

var ZFWPoint = { label: "ZFW", points: { show: true }, data: [[0, 0]] };
var TOWPoint = { label: "TOW", points: { show: true }, data: [[0, 0]], color: '#ff0000' };
var LWPoint = { label: "L/W", points: { show: true }, data: [[0, 0]] };

// Initialize PK-BMS
let fuelCgData = [[100,347.51], [200,695.02],[300,1030.04],[400,1356.72],[500,1687.35],[600,2014.57],
    [700,2338.36],[800,2658.73],[900,2983.62],[1000,3306.85],[1100,3628.42],[1200,3948.34],
    [1300,4272.49],[1400,4595.89],[1500,4918.53],[1600,5240.43],[1700,5565.39],[1800,5890.05],
    [1900,6214.4],[2000,6538.46],[2100,6864.94],[2200,7191.38],[2300,7517.77],[2400,7844.12],
    [2500,8170.98],[2600,8497.84],[2700,8824.70],[2800,9151.56],[2900,9478.6],[3000,9805.65],
    [3100,10132.72],[3200,10459.8],[3300,10787.22],[3400,11114.67],[3500,11442.15],[3600,11769.66],
    [3700,12097.61],[3800,12425.61],[3900,12753.67],[4000,13081.78],[4100,13410.41],[4200,13739.12],
    [4300,14067.91],[4400,14396.77],[4500,14726.26],[4600,15055.84],[4700,15385.53],[4800,15715.32],
    [4900,16046.52],[5000,16377.88],[5100,16709.4],[5200,17041.07],[5300,17374.8],[5400,17708.76],
    [5500,18042.94],[5600,18377.36],[5700,18712.41],[5800,19047.71],[5900,19383.26],[6000,19719.04],
    [6100,20054.19],[6200,20389.55],[6300,20725.12],[6400,21060.91],[6500,21396.48],[6600,21732.25],
    [6700,22067.29],[6790,22369.55]];

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

let aircraft = new Aircraft(12524.8, 42182.03, fuelCgData, 20400, 20200, 18700, 15100);
// Initialize Station List
aircraft.addStation('Seat1', 136.32);
aircraft.addStation('Seat2', 136.32);
aircraft.addStation('Seat10F', 181.24);
aircraft.addStation('Seat10A', 205.60);
aircraft.addStation('Seat3', 234.39);
aircraft.addStation('Seat4', 234.39);
aircraft.addStation('Seat5', 286.54);
aircraft.addStation('Seat6', 286.54);
aircraft.addStation('Seat7', 322.62);
aircraft.addStation('Seat8', 322.62);
aircraft.addStation('SFS', 357.99);
aircraft.addStation('CGO1', 431.0);
aircraft.addStation('CGO2', 157.99);
aircraft.addStation('CHRT1', 158.1);
aircraft.addStation('CHRT2', 166.22);
aircraft.addStation('REFRESHMENT', 172.47);
aircraft.addStation('TOILET', 357.99);

function getCrewPaxDistribution() {
    var data = {};
    data.paxCount = 0;
    data.crwCount = 0;
    data.paxWeight = 0;
    data.crwWeight = 0;
    
    var occupancy = [];
    
    for (const entry of aircraft.stations.entries())
    {
        let stationName = entry[0];
        var station = entry[1];
        
        if (stationName.startsWith("Seat") && entry[1].weight > 0) {
           if ($('#Type_' + stationName).val() == 'C') {
               data.crwCount += 1;
               data.crwWeight += entry[1].weight;
           } else {
               data.paxCount += 1;
               data.paxWeight += entry[1].weight;
           }
        }
        
        if (stationName == 'Seat10F' && entry[1].weight > 0) {
            occupancy.push('10FWD');
        } else if (stationName == 'Seat10A' && entry[1].weight > 0) {
            occupancy.push('10AFT');
        } else if (stationName == 'Seat3' && entry[1].weight > 0) {
            occupancy.push('3');
        } else if (stationName == 'Seat4' && entry[1].weight > 0) {
            occupancy.push('4');
        } else if (stationName == 'Seat5' && entry[1].weight > 0) {
            occupancy.push('5');
        } else if (stationName == 'Seat6' && entry[1].weight > 0) {
            occupancy.push('6');
        } else if (stationName == 'Seat7' && entry[1].weight > 0) {
            occupancy.push('7');
        } else if (stationName == 'Seat8' && entry[1].weight > 0) {
            occupancy.push('8');
        }
    }
    
    data.occupancy = occupancy.join('.');
    
    return data;
}

function updatePaylodComputation() {
    for (const entry of aircraft.stations.entries())
    {
        let stationName = entry[0];
        var station = entry[1];

        if ($('#W_PL_' + stationName).val() == '')
        {
            $('#W_PL_' + stationName).val('0');
        }

        var stationWeight = parseInt($('#W_PL_' + stationName).val());
        aircraft.setStationWeight(stationName, stationWeight);

        $('#CG_PL_' + stationName).html(station.getMoment().toFixed(3));        
    }

    $('#totalPayloadWeight').html(aircraft.totalPayloadWeight);
    $('#totalPayloadMoment').html(aircraft.totalPayloadMoment.toFixed(3));

    $('#payloadWeight').html(aircraft.totalPayloadWeight);
    $('#payloadMoment').html(aircraft.totalPayloadMoment.toFixed(3));

    $('#zfw').html(aircraft.getZfw());
    $('#zfwMoment').html(aircraft.getZfwMoment().toFixed(3));

    $('#zfwCg').html(aircraft.getZfwCg().toFixed(3));

    var fuelWeight = parseInt($('#blockFuel').val());
    var result = aircraft.setFuelWeight(fuelWeight);
    if (!result)
    {
        alert("Unable to get Block Fuel Moment data");
    }
    $('#blockFuelMoment').html(aircraft.fuelMoment.toFixed(3));

    $('#rampWeight').html(aircraft.getRampWeight());
    $('#rampWeightMoment').html(aircraft.getRampWeightMoment().toFixed(3));

    var taxiFuelWeight = parseInt($('#taxiFuel').val());
    result = aircraft.setTaxiFuelWeight(taxiFuelWeight);
    if (!result)
    {
        alert("Unable to get Taxi Fuel Moment data");
    }
    $('#taxiFuelMoment').html(aircraft.taxiFuelMoment.toFixed(3));

    $('#tow').html(aircraft.getTow());
    $('#towMoment').html(aircraft.getTowMoment().toFixed(3));

    $('#towCg').html(aircraft.getTowCg().toFixed(3));
    $('#towCgPercent').html(aircraft.getTowCgPercent().toFixed(3));

    var tripFuelWeight = parseInt($('#tripFuel').val());
    result = aircraft.setTripFuelWeight(tripFuelWeight);
    if (!result)
    {
        alert("Unable to get Trip Fuel Moment data");
    }
    $('#tripFuelMoment').html(aircraft.tripFuelMoment.toFixed(3));

    $('#law').html(aircraft.getLaw());
    $('#lawMoment').html(aircraft.getLawMoment().toFixed(3));
    $('#lawCg').html(aircraft.getLawCg().toFixed(3));

    // Set Limitation
    $('#maxRampWeight').html(aircraft.maxRampWeight);
    if (aircraft.getRampWeight() > aircraft.maxRampWeight)
    {
        $('#rampWeight').removeClass('text-success').addClass('text-danger');
    }
    else
    {
        $('#rampWeight').removeClass('text-danger').addClass('text-success');
    }
    $('#mzfw').html(aircraft.mzfw);
    if (aircraft.zfw > aircraft.mzfw)
    {
        $('#zfw').removeClass('text-success').addClass('text-danger');
    }
    else
    {
        $('#zfw').removeClass('text-danger').addClass('text-success');
    }
    $('#mtow').html(aircraft.mtow);
    if (aircraft.getTow() > aircraft.mtow)
    {
        $('#tow').removeClass('text-success').addClass('text-danger');
    }
    else
    {
        $('#tow').removeClass('text-danger').addClass('text-success');
    }
    $('#mlw').html(aircraft.mlw);
    if (aircraft.getLaw() > aircraft.mlw)
    {
        $('#law').removeClass('text-success').addClass('text-danger');
    }
    else
    {
        $('#law').removeClass('text-danger').addClass('text-success');
    }   

    // Draw chart
    ZFWPoint.data[0][0] = aircraft.getZfwCg();
    ZFWPoint.data[0][1] = aircraft.getZfw() / 1000;   

    TOWPoint.data[0][0] = aircraft.getTowCg();
    TOWPoint.data[0][1] = aircraft.getTow() / 1000;

    LWPoint.data[0][0] = aircraft.getLawCg();
    LWPoint.data[0][1] = aircraft.getLaw() / 1000;

    var placeholder = $("#LoadsheetChart");

    var plot = $.plot(placeholder, [envelope, ZFWPoint, TOWPoint, LWPoint, maxTowLine,
        maxLawLine, maxZfwLine], options);
        
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
            
        
    // Set Post JSON Data
    var data = {};
    data.bow = aircraft.basicEmptyWeight.toFixed(0);
    data.zfw = aircraft.getZfw().toFixed(0);
    data.zfwCg = aircraft.getZfwCg();
    data.payload = aircraft.totalPayloadWeight.toFixed(0);
    data.tow = aircraft.getTow().toFixed(0);
    data.towCg = aircraft.getTowCg();
    data.law = aircraft.getLaw().toFixed(0);
    data.lawCg = aircraft.getLawCg();
    data.cargoWeight = $('#W_PL_CGO1').val() + '/' + $('#W_PL_CGO2').val();
    
    data.fuelWeight = aircraft.fuelWeight.toFixed(0);
    data.taxiFuel = aircraft.taxiFuelWeight.toFixed(0);
    data.toFuel = (aircraft.fuelWeight - aircraft.taxiFuelWeight).toFixed(0);
    data.tripFuel = aircraft.tripFuelWeight.toFixed(0);
    data.landingFuel = (aircraft.fuelWeight - aircraft.taxiFuelWeight - aircraft.tripFuelWeight).toFixed(0);
    
    data.zfwCgPercent = aircraft.getZfwCgPercent().toFixed(3);
    data.towCgPercent = aircraft.getTowCgPercent().toFixed(3);
    data.lawCgPercent = aircraft.getLawCgPercent().toFixed(3);
    
    var crewPaxDist = getCrewPaxDistribution();
    data.crewWeight = crewPaxDist.crwCount + '/' + crewPaxDist.crwWeight;
    data.paxWeight = crewPaxDist.paxCount + '/' + crewPaxDist.paxWeight;
    data.totalPob = crewPaxDist.crwCount + crewPaxDist.paxCount;
    data.occupancy = crewPaxDist.occupancy;
    
    $('#loadsheetData').val(JSON.stringify(data));
}

$(document).ready(function () {

    $('#basicEmptyWeight').html(aircraft.basicEmptyWeight);
    $('#basicEmptyMoment').html(aircraft.basicEmptyWeightMoment);

    updatePaylodComputation();

    $("[id*='W_PL_']").change(function () {
        updatePaylodComputation();
    });

    $("#blockFuel").change(function () {
        updatePaylodComputation();
    });

    $("#taxiFuel").change(function () {
        updatePaylodComputation();
    });

    $("#tripFuel").change(function () {
        updatePaylodComputation();
    });

    window.onresize = function (event) {
        $.plot($("#LoadsheetChart"), [envelope, ZFWPoint, TOWPoint, LWPoint, maxTowLine,
            maxLawLine, maxZfwLine], options);
    }

});
