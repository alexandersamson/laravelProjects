<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CaseStateTableSeeder::class);
         $this->call(PermissionTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(ClientsTableSeeder::class);
         $this->call(CasefileTableSeeder::class);
    }
}
