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
            ['name' => 'John Doe', 'organization_id' => 1, 'email' => 'john@doe.com','phone_work' => '+31254565655', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jane Doe', 'organization_id' => 1, 'email' => 'jane@doe.com','phone_work' => '+31256555455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jim Doe', 'organization_id' => 2, 'email' => 'jim@doe.com',  'phone_work' => '+31254564355', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'Jack Doe', 'organization_id' => 3, 'email' => 'jack@doe.com','phone_work' => '+31254585455', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0],
            ['name' => 'July Doe', 'organization_id' => 4, 'email' => 'july@doe.com','phone_work' => '+312t6463555', 'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi', 'permission' => 0]

        ];
        foreach($clients as $client){
            Client::create($client);
        }
    }
}
