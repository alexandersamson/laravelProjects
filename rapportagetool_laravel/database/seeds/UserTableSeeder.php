<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $users = [
            ['name' => 'Alexander Samson', 'email' => 'alexander@gm7.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 511],
            ['name' => 'User NoPermission', 'email' => 'alexander@gm6.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 0],
            ['name' => 'User Staff', 'email' => 'alexander@gm5.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 1],
            ['name' => 'User Investigator', 'email' => 'alexander@gm4.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 2],
            ['name' => 'User StaffInvestigator', 'email' => 'alexander@gm3.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 3],
            ['name' => 'User Manag.Invest.', 'email' => 'alexander@gm2.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 7],
            ['name' => 'User 511', 'email' => 'alexander@gm1.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'phone' => '+31612345567', 'permission' => 511]

        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
//Password $2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi = kippensoep