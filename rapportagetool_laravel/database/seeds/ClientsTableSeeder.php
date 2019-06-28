<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            ['name' => 'John Doe', 'email' => 'john@doe.com','phone_work' => '+31254585455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jane Doe', 'email' => 'jane@doe.com','phone_work' => '+31254585455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jim Doe', 'email' => 'jim@doe.com',  'phone_work' => '+31254585455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jack Doe', 'email' => 'jack@doe.com','phone_work' => '+31254585455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0]

        ];
        foreach($clients as $client){
            Client::create($client);
        }
    }
}
