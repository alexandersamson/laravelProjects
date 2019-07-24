<?php

use App\Models\Casenote;
use Illuminate\Database\Seeder;

class CasenotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Casenote::class, 30)->create();
    }
}
