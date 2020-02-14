<?php

use Illuminate\Database\Seeder;
use App\Aircraft;

class AircraftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a1 = new Aircraft;
        $a1->registration = 'PK-BKS';
        $a1->active = true;
        $a1->save();
        
        $a2 = new Aircraft;
        $a2->registration = 'PK-BMS';
        $a2->active = true;
        $a2->save();
        
        $a3 = new Aircraft;
        $a3->registration = 'PK-JTR';
        $a3->active = true;
        $a3->save();
    }
}
