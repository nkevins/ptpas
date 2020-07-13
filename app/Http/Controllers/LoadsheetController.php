<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoadsheetController extends Controller
{
    public function pkbks()
    {
        return view('admin/loadsheet/pkbks');
    }
    
    public function pkbksPrint(Request $request)
    {
        $data = json_decode($request->input('loadsheetData'));
        $departure = strtoupper($request->input('departure'));
        $destination = strtoupper($request->input('destination'));
        
        $underweight = array(
                            "ZFW" => 15100 - $data->zfw,
                            "TOW" => 20200 - $data->tow,
                            "LAW" => 18700 - $data->law
                        );
        
        $underweightLimit = array_keys($underweight, min($underweight))[0];
        $underweightValue = $underweight[$underweightLimit];
        
        $maclimitfwd = array (
                            "ZFW" => round($this->pkbksGetFwdMacLimit($data->zfw), 3),
                            "TOW" => round($this->pkbksGetFwdMacLimit($data->tow), 3),
                            "LAW" => round($this->pkbksGetFwdMacLimit($data->law), 3),
                        );
                        
        $maclimitaft = array (
                            "ZFW" => round($this->pkbksGetAftMacLimit($data->zfw), 3),
                            "TOW" => round($this->pkbksGetAftMacLimit($data->tow), 3),
                            "LAW" => round($this->pkbksGetAftMacLimit($data->law), 3),
                        );
        
        return view('admin/loadsheet/pkbks_output', compact('data', 'departure', 'destination', 
                        'underweightLimit', 'underweightValue', 'maclimitfwd', 'maclimitaft'));
    }
    
    private function pkbksGetFwdMacLimit($weight) {
        $mac = 0;
        
        if ($weight >= 10000 && $weight <= 11500) {
    		$mac = 15;
    	} else if ($weight > 11500 && $weight <= 20400) {
    		$mac = ((($weight - 11500) * (21.52 - 15)) / (20400 - 11500)) + 15;
    	}
        
        return $mac;
    }
    
    private function pkbksGetAftMacLimit($weight) {
    	$mac = 0;
    	
    	if ($weight >= 10000 && $weight <= 15100) {
    		$mac = 30;
    	} else if ($weight > 15100 && $weight <= 17800) {
    		$mac = ((($weight - 17800) * (30 - 29.37)) / (15100 - 17800)) + 29.37;
    	} else if ($weight > 17800 && $weight <= 20400) {
    		$mac = 29.37;
    	}
    	
    	return $mac;
    }
}
