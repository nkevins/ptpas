@inject('helper', 'App\Helper')
    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{$data->general->icao_airline}}-{{$data->general->flight_number}}-{{strtoupper(date('d',(int)$data->times->sched_out))}}-{{strtoupper(date('m',(int)$data->times->sched_out))}}-{{strtoupper(date('y',(int)$data->times->sched_out))}}-{{strtoupper(date('Hi',(int)$data->times->sched_out))}}-{{$data->destination->icao_code}}</title>

    <style>
        @page {
            margin: 0.50cm 1.38cm 0.81cm 0.92cm;
            font-family: "Courier New", Courier, monospace;
        }
        .header {
            position: fixed;
            top: -10px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 8pt;
            color: #7D7D7D;

        }
        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: right;
            font-size: 8pt;
            color: #7D7D7D;
        }
        .page-number:before {
            content: "GARUDA INDONESIA BRIEF PAGE " counter(page) " of ";
        }
        .page-number-footer:before {
            content: "PAGE " counter(page) " of ";
        }
        pre {
            margin-top: 0;
            font-size: 10.5pt;
            line-height: 14.5pt;
            word-wrap: break-word;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="page-number">{{$totalPages ?? ''}}</div>
    </div>
    <div class="footer">
        <div class="page-number-footer">{{$totalPages ?? ''}}</div>
    </div>
    <pre>---------------------------------------------------------------------------
                             DISPATCH RELEASE
---------------------------------------------------------------------------
VALID U/I {{date('Hi',$data->times->sched_out + (3600  * 6))}}Z
REF PLAN {{substr($data->params->request_id, -5)}} / REV NBR {{$data->general->release}}
{{$data->atc->callsign}}   {{strtoupper(date('dMy',(int)$data->times->sched_out))}} ETD {{date('Hi',(int)$data->times->sched_out)}}Z  ETA {{date('Hi',(int)$data->times->est_in)}}Z / FT {{date('Hi',(int)$data->times->est_block)}} IFR {{$data->aircraft->reg}}

1.  POD/POA : {{$data->origin->icao_code}}/{{$data->destination->icao_code}}

2.  INITIAL DESTINATION (FOR PLANNED RE-DISPATCH AS APPLICABLE):

3.  WX
    ORG {{$data->origin->iata_code}}/{{$data->origin->icao_code}}  CHECKED             AL1 {{$data->alternate[0]->iata_code}}/{{$data->alternate[0]->icao_code}}  CHECKED
    DES {{$data->destination->iata_code}}/{{$data->destination->icao_code}}  CHECKED             @if(!empty($data->alternate[1]))AL2 {{$data->alternate[1]->iata_code}}/{{$data->alternate[1]->icao_code}}  CHECKED @endif


4.  NOTAM AND/OR AERONAUTICAL INFORMATION
    ALL NOTAMS SIGNIFICANT TO FLIGHT ARE CONSIDERED

5.  LOAD
    EST PAX ADL{{str_pad($data->weights->pax_count,3,'0',STR_PAD_LEFT)}}/CHD000/INF000          TOTAL  {{$data->weights->pax_count}}
    EST CGO {{$data->weights->cargo}} KGS
    EST PLD {{$data->weights->payload}} KGS

6.  FLIGHT PLAN DATA
    TRP   {{str_pad($data->fuel->enroute_burn, 6, '0', STR_PAD_LEFT)}}   KGS {{date('H:i',(int)$data->times->est_time_enroute)}}         EZF    {{str_pad($data->weights->est_zfw, 6, '0', STR_PAD_LEFT)}}   MAX {{str_pad($data->weights->max_zfw, 6, '0', STR_PAD_LEFT)}}
    RES   {{str_pad($data->fuel->reserve, 6, '0', STR_PAD_LEFT)}}   KGS {{date('H:i',(int)$data->times->reserve_time)}}         ELW    {{str_pad($data->weights->est_ldw, 6, '0', STR_PAD_LEFT)}}   MAX {{str_pad($data->weights->max_ldw, 6, '0', STR_PAD_LEFT)}}
    ALT   {{str_pad($data->fuel->alternate_burn, 6, '0', STR_PAD_LEFT)}}   KGS {{date('H:i',(int)$data->alternate->ete)}}         ETW    {{str_pad($data->weights->est_tow, 6, '0', STR_PAD_LEFT)}}   MAX {{str_pad($data->weights->max_tow, 6, '0', STR_PAD_LEFT)}}
    BLK   {{str_pad($data->fuel->plan_ramp, 6, '0', STR_PAD_LEFT)}}   KGS {{date('H:i',(int)$data->times->endurance)}}

7.  ETOPS FLIGHT: @if (empty($data->etops)) NO @else YES     ETOPS DIVERSION TIME: {{$data->etops->rule}} MIN @endif

@php
    if (!empty($data->etops))
    {
        $etopsAlternates = [];
        foreach($data->etops->suitable_airport as $airport) {
            $etopsAlternates[] = (string)$airport->icao_code;
        }
    }

    // Generate consistent FOO ID based on SimBrief requestId
    $hashInt = hexdec(substr($data->params->request_id, 0, 8));
    $fooId = 1000 + ($hashInt % 9000);

    $faker = Faker\Factory::create('id_ID');
    $data->crew->dx = $faker->firstName();

    $totalDistance = 0;
@endphp

8.  ENROUTE / ETOPS ALTERNATE:@if(!empty($data->etops)) {{implode(' ', $etopsAlternates)}} @endif


9.  TAKE OFF ALTERNATE (IF REQUIRED) : ......

10. DESTINATION ALTERNATE: 1. {{$data->alternate[0]->icao_code}}   2. ....

11. FUEL REQ AFTER BRIEF: ............. KGS

    REASON FOR DISCRETIONARY FUEL :....................

12. NOTOC  / (DGR):

13. REMARKS: NONE


I HEREBY RELEASE THIS FLIGHT IN FULL COMPLIANCE WITH CIVIL AVIATION SAFETY
REGULATIONS AND OPERATION MANUAL PART A (OM-A)
    DISPATCHED BY               : FOO. {{strtoupper($data->crew->dx)}} - {{$fooId}}

I HEREBY PREPARE AND ARRANGE THIS FLIGHT DISPATCH RELEASE ACCORDING TO THE
INSTRUCTION AND DATA PROVIDED BY PT. GARUDA INDONESIA (PERSERO) TBK.

    NAME / ID                   : .................. / ........

                                   SIGN ......................


I HEREBY ACCEPT THIS FLIGHT DISPATCH RELEASE WITH FULL ACKNOWLEDGEMENT.
    PILOT IN COMMAND            :  CAPT. {{strtoupper($data->crew->cpt)}}

                                   SIGN ......................
<div class="page-break"></div>---------------------------------------------------------------------------
                        COMPUTERIZED FLIGHT PLAN
---------------------------------------------------------------------------
PLAN {{substr($data->params->request_id, -5)}} / REV NUM {{str_pad($data->general->release, 2)}}       {{$data->origin->icao_code}} TO {{$data->destination->icao_code}}  {{$data->aircraft->icaocode}}  CI{{str_pad($data->general->costindex, 3, '0', STR_PAD_LEFT)}}/F  IFR  {{date('d/m/y',(int)$data->times->sched_out)}}
NONSTOP COMPUTED {{date('Hi',(int)$data->params->time_generated)}} ETD {{date('Hi',(int)$data->times->sched_out)}}Z PROGS {{$helper->getWeatherPrognosisTimes($data->times->sched_out)}} {{$data->aircraft->reg}}
KGS

GARUDA INDONESIA CFP

SPD SKD   CLB-{{$helper->formatClimbSpeedProfile($data->general->climb_profile)}}  CRZ-CI{{str_pad($data->general->costindex, 3, '0', STR_PAD_LEFT)}}   DSC-{{$helper->formatDescendSpeedProfile($data->general->descent_profile)}}
@if (!empty($data->etops))

ETOPS FLTPLN {{$data->etops->rule}} MINUTES
@endif

FUEL         CORR      ENDUR

{{str_pad($data->fuel->enroute_burn, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->est_time_enroute)}}    TRIPF INCL {{$helper->formatPerfPerfFactor((double)$data->aircraft->fuelfact)}}PCT HIGH CONS
{{str_pad($data->fuel->contingency, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->contfuel_time)}}    CONTINGENCY/RR
{{str_pad($data->fuel->reserve, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->reserve_time)}}    FINAL RESERVE FUEL
{{str_pad($data->fuel->alternate_burn, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->alternate->burn)}}    ALTN {{$data->alternate->icao_code}}
{{str_pad($helper->getFuelBucketFuelValue($data->fuel_extra, 'ATC'), 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'ATC'))}}    EXTRA HOLDING FUEL
{{str_pad($helper->getFuelBucketFuelValue($data->fuel_extra, 'WXX') + (int)$data->fuel->etops, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'WXX') + (int)$data->times->etopsfuel_time)}}    ADDITIONAL FUEL
{{str_pad($data->fuel->plan_takeoff - (int)$helper->getFuelBucketFuelValue($data->fuel_extra, 'TANKERING') - (int)$helper->getFuelBucketFuelValue($data->fuel_extra, 'EXTRA'), 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->endurance - (int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'TANKERING') - (int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'EXTRA'))}}    REQ
{{str_pad($helper->getFuelBucketFuelValue($data->fuel_extra, 'TANKERING'), 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'TANKERING'))}}    TANKERING
{{str_pad($helper->getFuelBucketFuelValue($data->fuel_extra, 'EXTRA'), 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$helper->getFuelBucketFuelTime($data->fuel_extra, 'EXTRA'))}}    DISCRETIONARY FUEL
{{str_pad($data->fuel->plan_takeoff, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->endurance)}}    TKOF
{{str_pad($data->fuel->taxi, 6, '0', STR_PAD_LEFT)}}       .. ..              TAXI
{{str_pad($data->fuel->plan_ramp, 6, '0', STR_PAD_LEFT)}}       .. ..     {{date('H:i',(int)$data->times->endurance)}}    BLOCK  FUEL REM .. ..

                ARR  .. ..     TDN   .. ..
                DEP  .. ..     A/B   .. ..
                FLT  .. ..     AIR   .. ..

FBURN ADJUSTMENT FOR 1000KGS INCR/DECR IN TOW {{str_pad($data->impacts->zfw_plus_1000->burn_difference,4,'0',STR_PAD_LEFT)}}KGS/{{str_pad(abs($data->impacts->zfw_minus_1000->burn_difference),4,'0',STR_PAD_LEFT)}}KGS

FL SUMMARIES
CRZ          TOW      TRF         TIM      FL
@if(!empty($data->impacts->plus_2000ft))
CI{{str_pad($data->impacts->plus_2000ft->cost_index, 3, '0', STR_PAD_LEFT)}}       {{str_pad($data->weights->est_tow,6,'0',STR_PAD_LEFT)}}   {{str_pad($data->impacts->plus_2000ft->enroute_burn, 6, '0', STR_PAD_LEFT)}}      {{date('H:i',(int)$data->impacts->plus_2000ft->time_enroute)}}     {{$data->impacts->plus_2000ft->initial_fl}}
@endif
CI{{str_pad($data->general->costindex, 3, '0', STR_PAD_LEFT)}}       {{str_pad($data->weights->est_tow,6,'0',STR_PAD_LEFT)}}   {{str_pad($data->fuel->enroute_burn, 6, '0', STR_PAD_LEFT)}}      {{date('H:i',(int)$data->times->est_time_enroute)}}     {{(int)$data->general->initial_altitude/100}}
@if(!empty($data->impacts->minus_2000ft))
CI{{str_pad($data->impacts->minus_2000ft->cost_index, 3, '0', STR_PAD_LEFT)}}       {{str_pad($data->weights->est_tow,6,'0',STR_PAD_LEFT)}}   {{str_pad($data->impacts->minus_2000ft->enroute_burn, 6, '0', STR_PAD_LEFT)}}      {{date('H:i',(int)$data->impacts->minus_2000ft->time_enroute)}}     {{$data->impacts->minus_2000ft->initial_fl}}
@endif

FLT NBR {{$data->atc->callsign}}   DTE {{date('d/m/y',(int)$data->times->sched_out)}}

 EZF       PLD        ELW       ETW     CRZ
{{str_pad($data->weights->est_zfw,6,'0',STR_PAD_LEFT)}}    {{str_pad($data->weights->payload,6,'0',STR_PAD_LEFT)}}     {{str_pad($data->weights->est_ldw,6,'0',STR_PAD_LEFT)}}    {{str_pad($data->weights->est_tow,6,'0',STR_PAD_LEFT)}}   CI{{str_pad($data->general->costindex, 3, '0', STR_PAD_LEFT)}}

@if (!empty($data->etops))
ENRT ALTN SUITABLE
@foreach ($data->etops->suitable_airport as $airport)
{{$airport->icao_code}} VALIDITY WINDOW {{Carbon\Carbon::parse($airport->suitability_start)->format('H:i')}}Z TO {{Carbon\Carbon::parse($airport->suitability_end)->format('H:i')}}Z
@endforeach

-E.ENT {{str_replace('.','',$helper->formatLatLon((double)$data->etops->entry->pos_lat_fix,(double)$data->etops->entry->pos_long_fix))}}  {{$helper->interpolateEtpDistance($data->etops->entry, $data->navlog)}} NM {{date('H:i',(int)$data->etops->entry->elapsed_time)}}    {{$data->etops->entry->icao_code}}  {{str_replace('.','',$helper->formatLatLon((double)$data->etops->entry->pos_lat_apt,(double)$data->etops->entry->pos_long_apt))}}
-E.EXT {{str_replace('.','',$helper->formatLatLon((double)$data->etops->exit->pos_lat_fix,(double)$data->etops->exit->pos_long_fix))}}  {{$helper->interpolateEtpDistance($data->etops->exit, $data->navlog)}} NM {{date('H:i',(int)$data->etops->exit->elapsed_time)}}    {{$data->etops->exit->icao_code}}  {{str_replace('.','',$helper->formatLatLon((double)$data->etops->exit->pos_lat_apt,(double)$data->etops->exit->pos_long_apt))}}

@php
    $etpIndex = 1;
    $criticalEtp = $data->etops->critical_point->fix_type;
    foreach ($data->etops->equal_time_point as $etp) {
        if ((double)$etp->pos_lat == (double)$data->etops->critical_point->pos_lat && (double)$etp->pos_long == (double)$data->etops->critical_point->pos_long) {
            $criticalEtp = 'ETP' . $etpIndex;
            break;
        }
        $etpIndex++;
    }

    $deficit = (double)$data->etops->critical_point->est_fob - (double)$data->etops->critical_point->critical_fuel;
    if ($deficit > 0) {
        $deficit = 0;
    } else {
        $deficit = abs($deficit);
    }
@endphp
MOST CRITICAL FUEL SCENARIO AT : {{$criticalEtp}} FUEL DEFICIT OF {{$deficit}} KGS

                                                         TIME TO
                   DIST        W/C    CFR   FOB    EXC   ETP/ALT
@php
$etpIndex=1;
@endphp
@foreach ($data->etops->equal_time_point as $etp)
ETP{{$etpIndex}} {{$etp->div_airport[0]->icao_code}}/{{$etp->div_airport[1]->icao_code}}   {{str_pad($etp->div_airport[0]->distance,4,'0',STR_PAD_LEFT)}}/{{str_pad($etp->div_airport[1]->distance,4,'0',STR_PAD_LEFT)}}  {{$helper->formatAvgWindComp((int)$etp->div_airport[0]->avg_wind_comp)}}/{{$helper->formatAvgWindComp((int)$etp->div_airport[1]->avg_wind_comp)}} {{str_pad($etp->critical_fuel,5,'0',STR_PAD_LEFT)}} {{str_pad($etp->est_fob,6,'0',STR_PAD_LEFT)}} {{str_pad((int)$etp->est_fob-(int)$etp->critical_fuel,5,'0',STR_PAD_LEFT)}} {{date('Hi',(int)$etp->elapsed_time)}}/{{date('Hi',(int)$etp->div_time)}}
     {{$helper->formatLatLonEtops((double)$etp->pos_lat,(double)$etp->pos_long)}}
@php
$etpIndex++;
@endphp
@endforeach
@endif

ETO TIM   AWY     WPT/FRQ      TTK   DIS  TAS  FLV   TD /TP   FBO    PFRM
ATO TIM      COORD             MTK   TTL  G/S  GMA   WIND     ABO    AFRM

        {{$data->origin->icao_code}}                                                 {{str_pad($data->fuel->taxi, 5, '0', STR_PAD_LEFT)}}  {{str_pad($data->fuel->plan_takeoff, 6, '0', STR_PAD_LEFT)}}
        ELEV {{$helper->formatAirportElevation($data->origin->elevation)}} FT
        {{$helper->formatLatLon($data->origin->pos_lat,(double)$data->origin->pos_long)}}

@foreach ($data->navlog->fix as $fix)
@php
$totalDistance += $fix->distance;
@endphp
@foreach ($fix->fir_crossing->fir as $fir)
    0000  {{str_pad($fix->via_airway,6)}} FIR/{{$fir->fir_icao}}      {{$fix->track_true}}T  000  {{str_pad($fix->true_airspeed,3,'0',STR_PAD_LEFT)}}  @if($fix->stage=='CLB')CLB @else{{str_pad((int)$fix->altitude_feet/100,3,'0',STR_PAD_LEFT)}} @endif  {{str_pad($helper->getIsa($fix),7)}} {{str_pad(($fix->fuel_totalused),5,'0',STR_PAD_LEFT)}}  {{str_pad($fix->fuel_plan_onboard,6,'0',STR_PAD_LEFT)}}
    {{date('Hi',(int)$fix->time_total)}}    {{$helper->formatLatLon((double)$fir->pos_lat_entry,(double)$fir->pos_lat_entry)}}    {{$fix->track_mag}}M  0000 {{str_pad($fix->groundspeed,3,'0',STR_PAD_LEFT)}}  {{str_pad((int)$fix->mora/100,3,'0',STR_PAD_LEFT)}}   {{$fix->wind_dir}}{{str_pad($fix->wind_spd,3,'0',STR_PAD_LEFT)}}

@endforeach
    {{date('Hi',(int)$fix->time_leg)}}  {{str_pad($fix->via_airway,6)}} {{str_pad($helper->reformatCoordinate($fix->ident).' '.$fix->frequency,12)}}  {{$fix->track_true}}T  {{str_pad($fix->distance,3,'0',STR_PAD_LEFT)}}  {{str_pad($fix->true_airspeed,3,'0',STR_PAD_LEFT)}}  @if($fix->stage=='CLB')CLB @else{{str_pad((int)$fix->altitude_feet/100,3,'0',STR_PAD_LEFT)}} @endif  {{str_pad($helper->getIsa($fix),7)}} {{str_pad(($fix->fuel_totalused),5,'0',STR_PAD_LEFT)}}  {{str_pad($fix->fuel_plan_onboard,6,'0',STR_PAD_LEFT)}}
    {{date('Hi',(int)$fix->time_total)}}    {{$helper->formatLatLon((double)$fix->pos_lat,(double)$fix->pos_long)}}    {{$fix->track_mag}}M  {{str_pad($totalDistance,4,'0',STR_PAD_LEFT)}} {{str_pad($fix->groundspeed,3,'0',STR_PAD_LEFT)}}  {{str_pad((int)$fix->mora/100,3,'0',STR_PAD_LEFT)}}   {{$fix->wind_dir}}{{str_pad($fix->wind_spd,3,'0',STR_PAD_LEFT)}}
        @if ($fix->ident == (string)$data->destination->icao_code)ELEV {{$helper->formatAirportElevation($data->destination->elevation)}} FT @endif

@endforeach

{{$helper->getFormattedFir($data->atc->section18)}}
TRACK USED = -OPT

G/C DIST {{$data->origin->icao_code}}/{{$data->destination->icao_code}}  {{$data->general->gc_distance}} NM

ROUTE DIST {{$data->general->route_distance}}NM

MAX FL / AVG.TAS  {{$helper->getMaxAlt($data->navlog)/100}} / {{$data->general->cruise_tas}}

AVG COMP {{$helper->formatAvgWindComp($data->general->avg_wind_comp)}}

         GMA  DIST  TTK  W/C   FL   TIME   FUEL BOF
@foreach ($data->alternate as $alternate)
{{$alternate->icao_code}}          {{str_pad($alternate->distance,4,'0',STR_PAD_LEFT)}}  {{str_pad($alternate->track_true,3,'0',STR_PAD_LEFT)}}  {{$alternate->avg_wind_comp}}  {{(int)$alternate->cruise_altitude/100}}  {{date('H.i',(int)$alternate->ete)}}  {{str_pad($alternate->burn,6,'0',STR_PAD_LEFT)}}
         {{$data->destination->icao_code}} {{wordwrap($alternate->route_ifps, 50, "\n" ,true)}} {{$alternate->icao_code}}
@endforeach

                             ALTERNATE DATA

ETO TIM   AWY     WPT/FRQ      TTK   DIS  TAS  FLV   TD /TP   FBO    PFRM
ATO TIM      COORD             MTK   TTL  G/S  GMA   WIND     ABO    AFRM


@if (!empty($data->alternate_navlog))
@foreach ($data->alternate_navlog[0]->fix as $fix)
@php
$totalDistance += $fix->distance;
@endphp
    {{date('Hi',(int)$fix->time_leg)}}  {{str_pad($fix->via_airway,6)}} {{str_pad($helper->reformatCoordinate($fix->ident).' '.$fix->frequency,12)}}  {{$fix->track_true}}T  {{str_pad($fix->distance,3,'0',STR_PAD_LEFT)}}  {{str_pad($fix->true_airspeed,3,'0',STR_PAD_LEFT)}}  @if($fix->stage=='CLB')CLB @else{{str_pad((int)$fix->altitude_feet/100,3,'0',STR_PAD_LEFT)}} @endif  {{str_pad($helper->getIsa($fix),7)}} {{str_pad(($fix->fuel_totalused),5,'0',STR_PAD_LEFT)}}  {{str_pad($fix->fuel_plan_onboard,6,'0',STR_PAD_LEFT)}}
    {{date('Hi',(int)$fix->time_total)}}    {{$helper->formatLatLon((double)$fix->pos_lat,(double)$fix->pos_long)}}    {{$fix->track_mag}}M  {{str_pad($totalDistance,4,'0',STR_PAD_LEFT)}} {{str_pad($fix->groundspeed,3,'0',STR_PAD_LEFT)}}  {{str_pad((int)$fix->mora/100,3,'0',STR_PAD_LEFT)}}   {{$fix->wind_dir}}{{str_pad($fix->wind_spd,3,'0',STR_PAD_LEFT)}}
        @if ($fix->ident == (string)$data->alternate->icao_code)ELEV {{$helper->formatAirportElevation($data->alternate->elevation)}} FT @endif

@endforeach
@endif

CLIMB
         @for ($i = 1; $i <= 7; $i++)FL{{str_pad((int)$data->navlog->fix[0]->wind_data->level[$i]->altitude/100,3,'0',STR_PAD_LEFT)}}     @endfor

@foreach ($data->navlog->fix as $fix)
@if($fix->stage == 'CLB' && $fix->ident != 'TOC')
{{str_pad($helper->reformatCoordinate($fix->ident),8,' ')}}@for ($i = 1; $i <= 7; $i++){{str_pad($fix->wind_data->level[$i]->wind_dir,3,'0',STR_PAD_LEFT)}}{{str_pad($fix->wind_data->level[$i]->wind_spd,3,'0',STR_PAD_LEFT)}}{{$helper->formatOat($fix->wind_data->level[$i]->oat)}} @endfor

@endif
@endforeach

CRUISE
@php
    $firstCruiseFix = null;
    foreach($data->navlog->fix as $fix) {
        if ($fix->stage == 'CRZ') {
            $firstCruiseFix = $fix;
            break;
        }
    }
@endphp
         @for ($i = 3; $i <= 9; $i++)FL{{str_pad((int)$firstCruiseFix->wind_data->level[$i]->altitude/100,3,'0',STR_PAD_LEFT)}}     @endfor

@foreach ($data->navlog->fix as $fix)
@if($fix->stage == 'CRZ' && $fix->ident != 'TOD')
{{str_pad($helper->reformatCoordinate($fix->ident),8,' ')}}@for ($i = 1; $i <= 7; $i++){{str_pad($fix->wind_data->level[$i]->wind_dir,3,'0',STR_PAD_LEFT)}}{{str_pad($fix->wind_data->level[$i]->wind_spd,3,'0',STR_PAD_LEFT)}}{{$helper->formatOat($fix->wind_data->level[$i]->oat)}} @endfor

@endif
@endforeach

DESCENT
@php
    $firstDescentFix = null;
    foreach($data->navlog->fix as $fix) {
        if ($fix->stage == 'DSC') {
            $firstDescentFix = $fix;
            break;
        }
    }
@endphp
         @for ($i = 1; $i <= 7; $i++)FL{{str_pad((int)$firstDescentFix->wind_data->level[$i]->altitude/100,3,'0',STR_PAD_LEFT)}}     @endfor

@foreach ($data->navlog->fix as $fix)
@if($fix->stage == 'DSC')
{{str_pad($helper->reformatCoordinate($fix->ident),8,' ')}}@for ($i = 1; $i <= 7; $i++){{str_pad($fix->wind_data->level[$i]->wind_dir,3,'0',STR_PAD_LEFT)}}{{str_pad($fix->wind_data->level[$i]->wind_spd,3,'0',STR_PAD_LEFT)}}{{$helper->formatOat($fix->wind_data->level[$i]->oat)}} @endfor

@endif
@endforeach

I CERTIFY THAT HAVE SATISFIED MYSELF THAT ALL FACTORS WHICH FORM THE BASIS OF
FLIGHT PREPARATION ARE IN ACCORDANCE WITH THE PERTINENT REGULATIONS LAID DOWN
BY THE INDONESIAN CIVIL AVIATION, CAPTAIN {{strtoupper($data->crew->cpt)}}

PIC             : CAPTAIN {{strtoupper($data->crew->cpt)}}

SIGN            : .. .. .. .. .. ..

PREPARED BY     : FOO. {{strtoupper($data->crew->dx)}} - {{$fooId}}

CAPTAINS SIGNATURE FOR COMPLETION OF JOURNAL AFTER FLIGHT

                                      .. .. .. .. ..

@foreach(explode("\n", $data->atc->flightplan_text) as $line)
@if(!empty($line))
{{$line}}
@endif
@endforeach

@if (!empty($data->etops))
- - - - - - - - - - - - - - - - - - - - - - - -	- - - - - - - - - - - - -

@foreach ($data->etops->equal_time_point as $etp)
2D
ETP {{str_replace('.', '', $helper->formatLatLonEtops((double)$etp->pos_lat, (double)$etp->pos_long))}}
TO ETP BURN {{str_pad($data->fuel->plan_takeoff - $etp->est_fob, 6, '0', STR_PAD_LEFT)}}
       TIME  {{date('H.i', (int)$etp->elapsed_time)}}
       DIST   {{str_pad($helper->interpolateEtpAnalysisDistance($etp, $data->navlog), 4, '0', STR_PAD_LEFT)}}
       ETP AIRPORTS
       {{$etp->div_airport[0]->icao_code}}    {{$etp->div_airport[1]->icao_code}}
TIME   {{date('H.i', (int)$etp->div_time)}}   {{date('H.i', (int)$etp->div_time)}}
RQFUEL {{str_pad($etp->div_burn, 6, '0', STR_PAD_LEFT)}}  {{str_pad($etp->div_burn, 6, '0', STR_PAD_LEFT)}}
FL     {{(int)$etp->div_altitude / 100}}     {{(int)$etp->div_altitude / 100}}
DIST   {{str_pad($etp->div_airport[0]->distance, 4, '0', STR_PAD_LEFT)}}    {{str_pad($etp->div_airport[1]->distance, 4, '0', STR_PAD_LEFT)}}
WIND   {{$helper->formatEtopsAvgWindComp($etp->div_airport[0]->avg_wind_comp)}}     {{$helper->formatEtopsAvgWindComp($etp->div_airport[1]->avg_wind_comp)}}

- - - - - - - - - - - - - - - - - - - - - - - -	- - - - - - - - - - - - -

@endforeach
@endif



END OF NAVTECH DATAPLAN
REQUEST NO. {{substr($data->params->request_id, -5)}} / REV NBR {{$data->general->release}}
    </pre>
</body>
</html>
