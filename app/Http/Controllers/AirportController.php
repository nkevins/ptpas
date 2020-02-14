<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::all();
        return view('admin/airport/index', compact('airports'));
    }
    
    public function create()
    {
        return view('admin/airport/create');
    }
    
    public function save(Request $request)
    {
        $ap = new Airport;
        $ap->name = $request->input('name');
        $ap->save();
        
        flash()->success('Airport Created')->important();
        return redirect()->action('AirportController@index');
    }
    
    public function edit($id)
    {
        $ap = Airport::find($id);
        
        if ($ap == null) {
            abort(404);
        }
        
        return view('admin/airport/edit', compact('ap'));
    }
    
    public function update(Request $request, $id)
    {
        $ap = Airport::findOrFail($id);
        $ap->name = $request->input('name');
        $ap->active = $request->input('active') == "1" ? true : false;
        $ap->save();
        
        flash()->success('Airport Updated')->important();
        return redirect()->action('AirportController@index');
    }
}
