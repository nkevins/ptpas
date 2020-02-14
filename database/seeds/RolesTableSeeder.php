<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r1 = new Role;
        $r1->name = 'Admin';
        $r1->save();
        
        $r2 = new Role;
        $r2->name = 'Pilot';
        $r2->save();
        
        $r3 = new Role;
        $r3->name = 'Report';
        $r3->save();
    }
}
