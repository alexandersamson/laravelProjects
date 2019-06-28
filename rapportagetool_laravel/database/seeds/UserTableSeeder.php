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
            ['name' => 'Alexander Samson', 'email' => 'alexander@gm7.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 1023],
            ['name' => 'Alexander RegUser', 'email' => 'alexander@gm6.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 1],
            ['name' => 'Alexander Client', 'email' => 'alexander@gm5.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 3],
            ['name' => 'Alexander Investigator', 'email' => 'alexander@gm4.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 5],
            ['name' => 'Alexander Manager', 'email' => 'alexander@gm3.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 65],
            ['name' => 'Alexander Manag.Invest.', 'email' => 'alexander@gm2.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 69],
            ['name' => 'Alexander Moderator', 'email' => 'alexander@gm1.nl', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 9]

        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
//Password $2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi = kippensoep