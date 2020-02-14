<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FlightLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    
    public function index()
    {
        return view('admin/dashboard');
    }
    
    public function totalFlightsStatisticData(Request $request)
    {
        if (!$request->has('from_date') || !$request->has('to_date')) {
            abort('400');
        }
        
        $fromDate = Carbon::createFromFormat('d/m/Y', $request->input('from_date'))->startOfDay();
        $toDate = Carbon::createFromFormat('d/m/Y', $request->input('to_date'))->startOfDay();
        
        $stats = DB::table('flight_logs')
                    ->select(DB::raw('registration, count(*) as flight_count'))
                    ->join('aircrafts', 'aircrafts.id', '=', 'flight_logs.aircraft_id')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->groupBy('registration')
                    ->get();
                    
        return $stats->toJson();
    }
    
    public function flightHoursStatisticData(Request $request)
    {
        if (!$request->has('from_date') || !$request->has('to_date')) {
            abort('400');
        }
        
        $fromDate = Carbon::createFromFormat('d/m/Y', $request->input('from_date'))->startOfDay();
        $toDate = Carbon::createFromFormat('d/m/Y', $request->input('to_date'))->startOfDay();
        
        $stats = DB::table('flight_logs')
                    ->select(DB::raw('registration, sum(block_time) as block_time'))
                    ->join('aircrafts', 'aircrafts.id', '=', 'flight_logs.aircraft_id')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->groupBy('registration')
                    ->get();
                    
        return $stats->toJson();
    }
    
    public function crewHoursStatisticData(Request $request)
    {
        if (!$request->has('from_date') || !$request->has('to_date')) {
            abort('400');
        }
        
        $fromDate = Carbon::createFromFormat('d/m/Y', $request->input('from_date'))->startOfDay();
        $toDate = Carbon::createFromFormat('d/m/Y', $request->input('to_date'))->startOfDay();
        
        $picStats = DB::table('flight_logs')
                    ->select(DB::raw('name, sum(block_time) as block_time'))
                    ->join('users', 'users.id', '=', 'flight_logs.pic')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->groupBy('pic')
                    ->get();
                    
        $sicStats = DB::table('flight_logs')
                    ->select(DB::raw('name, sum(block_time) as block_time'))
                    ->join('users', 'users.id', '=', 'flight_logs.sic')
                    ->where('date', '>=', $fromDate)
                    ->where('date', '<=', $toDate)
                    ->groupBy('sic')
                    ->get();
                    
        $crewHours = array();
        foreach ($picStats as $p) {
            if (!array_key_exists($p->name, $crewHours)) {
                $crewHours[$p->name] = intval($p->block_time);
            }
            else
            {
                $crewHours[$p->name] += intval($p->block_time);
            }
        }
        foreach ($sicStats as $s) {
            if (!array_key_exists($s->name, $crewHours)) {
                $crewHours[$s->name] = intval($s->block_time);
            }
            else
            {
                $crewHours[$s->name] += intval($s->block_time);
            }
        }
        
        $crewHoursJson = array();
        foreach ($crewHours as $key => $value) {
            $chArray = array( 
                            "name" => $key, 
                            "hours" => $value
                        );
            array_push($crewHoursJson, $chArray);
        }
                    
        return response()->json($crewHoursJson);
    }
}
