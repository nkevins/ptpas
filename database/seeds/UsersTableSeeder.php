<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User;
        $u->name = 'Zulfachri Harahap';
        $u->username = 'zulfachri.harahap';
        $u->password = Hash::make('P@ssw0rd');
        $u->active = true;
        $u->save();
        
        $r = Role::where('name', 'Admin')->first();
        $u->roles()->attach($r);
    }
}
