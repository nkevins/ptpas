<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Aircraft;
use App\Airport;
use App\FlightLog;
use App\User;
use Carbon\Carbon;
use DataTables;

class FlightLogController extends Controller
{
    public function index()
    {
        return view('admin/flight_log/index');
    }
    
    public function flightLogData()
    {
        $model = FlightLog::with('aircraft', 'departure', 'destination', 'pic', 'sic');
        
        return DataTables::eloquent($model)->toJson();
    }
    
    public function create()
    {
        $aircrafts = Aircraft::orderBy('registration')->where('active', true)->get();
        $airports = Airport::orderBy('name')->where('active', true)->get();
        $pilots = User::where('active', true)
                    ->whereHas('roles', function (Builder $query) {
                        $query->where('name', 'Pilot');
                    })->get();
        
        return view('admin/flight_log/create', compact('aircrafts', 'airports', 'pilots'));
    }
    
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:d/m/Y',
            'techLogNo' => 'required',
            'blockOff' => 'required|date_format:H:i',
            'blockOn' => 'required|date_format:H:i'
        ]);
        
        if ($validator->fails()) {
            flash()->error($validator->errors()->first())->important();
            return redirect()->back()->withInput();
        }
        
        $fl = new FlightLog;
        $fl->date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $fl->techlog = $request->input('techLogNo');
        $fl->aircraft_id = $request->input('aircraft');
        $fl->departure = $request->input('from');
        $fl->destination = $request->input('to');
        if (trim($request->input('route')) != '')
            $fl->route = $request->input('route');
        else
            $fl->route = '';
        $fl->off_time = $request->input('blockOff');
        $fl->on_time = $request->input('blockOn');
        
        $offTime = Carbon::createFromFormat('H:i', $fl->off_time);
        $onTime = Carbon::createFromFormat('H:i', $fl->on_time);
        if ($onTime < $offTime) {
            $onTime->addDay(1);
        }
        $fl->block_time = $offTime->diffInMinutes($onTime);
        
        $fl->pic = $request->input('pic');
        if (trim($request->input('sic')) != '')
            $fl->sic = $request->input('sic');
        else
            $fl->sic = null;
        if (trim($request->input('eob1')) != '')
            $fl->eob1 = $request->input('eob1');
        else
            $fl->eob1 = '';
        if (trim($request->input('eob2')) != '')
            $fl->eob2 = $request->input('eob2');
        else
            $fl->eob2 = '';
        if (trim($request->input('pax')) != '')
            $fl->pax = $request->input('pax');
        else
            $fl->pax = '';
        if (trim($request->input('remarks')) != '')
            $fl->remarks = $request->input('remarks');
        else
            $fl->remarks = '';
        $fl->save();
        
        flash()->success('Flight Log Added')->important();
        return redirect()->action('FlightLogController@index');
    }
    
    public function edit($id)
    {
        $fl = FlightLog::findOrFail($id);
        $aircrafts = Aircraft::orderBy('registration')->where('active', true)->get();
        $airports = Airport::orderBy('name')->where('active', true)->get();
        $pilots = User::where('active', true)
                    ->whereHas('roles', function (Builder $query) {
                        $query->where('name', 'Pilot');
                    })->get();
        $block_time = $this->convertDurationIntToString($fl->block_time);
        $formatted_off_time = Carbon::createFromFormat('H:i:s', $fl->off_time)->format('H:i');
        $formatted_on_time = Carbon::createFromFormat('H:i:s', $fl->on_time)->format('H:i');
        
        return view('admin/flight_log/edit', compact('fl', 'aircrafts', 'airports', 'pilots', 'block_time',
                    'formatted_off_time', 'formatted_on_time'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:d/m/Y',
            'techLogNo' => 'required',
            'blockOff' => 'required|date_format:H:i',
            'blockOn' => 'required|date_format:H:i'
        ]);
        
        if ($validator->fails()) {
            flash()->error($validator->errors()->first())->important();
            return redirect()->back()->withInput();
        }
        
        $fl = FlightLog::findOrFail($id);
        
        $fl->date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $fl->techlog = $request->input('techLogNo');
        $fl->aircraft_id = $request->input('aircraft');
        $fl->departure = $request->input('from');
        $fl->destination = $request->input('to');
        if (trim($request->input('route')) != '')
            $fl->route = $request->input('route');
        else
            $fl->route = '';
        $fl->off_time = $request->input('blockOff');
        $fl->on_time = $request->input('blockOn');
        
        $offTime = Carbon::createFromFormat('H:i', $fl->off_time);
        $onTime = Carbon::createFromFormat('H:i', $fl->on_time);
        if ($onTime < $offTime) {
            $onTime->addDay(1);
        }
        $fl->block_time = $offTime->diffInMinutes($onTime);
        
        $fl->pic = $request->input('pic');
        if (trim($request->input('sic')) != '')
            $fl->sic = $request->input('sic');
        else
            $fl->sic = null;
        if (trim($request->input('eob1')) != '')
            $fl->eob1 = $request->input('eob1');
        else
            $fl->eob1 = '';
        if (trim($request->input('eob2')) != '')
            $fl->eob2 = $request->input('eob2');
        else
            $fl->eob2 = '';
        if (trim($request->input('pax')) != '')
            $fl->pax = $request->input('pax');
        else
            $fl->pax = '';
        if (trim($request->input('remarks')) != '')
            $fl->remarks = $request->input('remarks');
        else
            $fl->remarks = '';
        $fl->save();
        
        flash()->success('Flight Log Updated')->important();
        return redirect()->action('FlightLogController@index');
    }
    
    public function delete(Request $request)
    {
        $fl = FlightLog::findOrFail($request->input('id'));
        $fl->delete();
        
        flash()->success('Flight Log Deleted')->important();
        return redirect()->action('FlightLogController@index');
    }
    
    private function parseDurationString($duration)
    {
        $hour = substr($duration, 0, 2);
        $minute = substr($duration, 3, 2);
        return $hour * 60 + $minute;
    }
    
    private function convertDurationIntToString($duration)
    {
        $hour = floor($duration / 60);
        $minute = $duration % 60;
        return str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
    }
}
