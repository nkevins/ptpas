<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightLog extends Model
{
    protected $dates = [
        'date',
    ];
    
    public function aircraft()
    {
        return $this->belongsTo('App\Aircraft');
    }
    
    public function departure()
    {
        return $this->belongsTo('App\Airport', 'departure');
    }
    
    public function destination()
    {
        return $this->belongsTo('App\Airport', 'destination');
    }
    
    public function pic()
    {
        return $this->belongsTo('App\User', 'pic');
    }
    
    public function sic()
    {
        return $this->belongsTo('App\User', 'sic');
    }
}
