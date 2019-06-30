<?php

use App\AssignedClient;
use Illuminate\Database\Seeder;

class AssignedClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignedInvestigators = [
            ['client_id' => 1, 'casefile_id' => 1, 'is_first_contact' => true, 'can_read_only' => false],
            ['client_id' => 5, 'casefile_id' => 1, 'is_first_contact' => false, 'can_read_only' => false],
            ['client_id' => 1, 'casefile_id' => 2, 'is_first_contact' => true, 'can_read_only' => false],
            ['client_id' => 2, 'casefile_id' => 3, 'is_first_contact' => true, 'can_read_only' => false],
            ['client_id' => 3, 'casefile_id' => 4, 'is_first_contact' => true, 'can_read_only' => false],
            ['client_id' => 3, 'casefile_id' => 5, 'is_first_contact' => true, 'can_read_only' => false],
            ['client_id' => 4, 'casefile_id' => 6, 'is_first_contact' => true, 'can_read_only' => false],


        ];
        foreach($assignedInvestigators as $aI){
            AssignedClient::create($aI);
        }
    }
}
