<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aircraft;

class AircraftController extends Controller
{
    public function index()
    {
        $aircrafts = Aircraft::all();
        return view('admin/aircraft/index', compact('aircrafts'));
    }
    
    public function create()
    {
        return view('admin/aircraft/create');
    }
    
    public function save(Request $request)
    {
        $ac = new Aircraft;
        $ac->registration = $request->input('registration');
        $ac->save();
        
        flash()->success('Aircraft Created')->important();
        return redirect()->action('AircraftController@index');
    }
    
    public function edit($id)
    {
        $ac = Aircraft::find($id);
        
        if ($ac == null) {
            abort(404);
        }
        
        return view('admin/aircraft/edit', compact('ac'));
    }
    
    public function update(Request $request, $id)
    {
        $ac = Aircraft::findOrFail($id);
        $ac->registration = $request->input('registration');
        $ac->active = $request->input('active') == "1" ? true : false;
        $ac->save();
        
        flash()->success('Aircraft Updated')->important();
        return redirect()->action('AircraftController@index');
    }
}
