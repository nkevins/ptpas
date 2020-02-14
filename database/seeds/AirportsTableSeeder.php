<?php

use Illuminate\Database\Seeder;
use App\Airport;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a1 = new Airport;
        $a1->name = 'Kuala Namu';
        $a1->active = true;
        $a1->save();
        
        $a2 = new Airport;
        $a2->name = 'Halim';
        $a2->active = true;
        $a2->save();
        
        $a3 = new Airport;
        $a3->name = 'Seletar';
        $a3->active = true;
        $a3->save();
        
        $a4 = new Airport;
        $a4->name = 'Martubung';
        $a4->active = true;
        $a4->save();
        
        $a5 = new Airport;
        $a5->name = 'Sampit';
        $a5->active = true;
        $a5->save();
    }
}
