<?php

use App\AssignedInvestigator;
use Illuminate\Database\Seeder;

class AssignedInvestigatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignedInvestigators = [
            ['user_id' => 1, 'casefile_id' => 1, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 5, 'casefile_id' => 1, 'is_lead_investigator' => false, 'can_read_only' => false],
            ['user_id' => 4, 'casefile_id' => 1, 'is_lead_investigator' => false, 'can_read_only' => false],
            ['user_id' => 1, 'casefile_id' => 2, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 1, 'casefile_id' => 3, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 4, 'casefile_id' => 3, 'is_lead_investigator' => false, 'can_read_only' => true],
            ['user_id' => 5, 'casefile_id' => 4, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 4, 'casefile_id' => 4, 'is_lead_investigator' => false, 'can_read_only' => false],
            ['user_id' => 1, 'casefile_id' => 5, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 1, 'casefile_id' => 6, 'is_lead_investigator' => true, 'can_read_only' => false],
            ['user_id' => 4, 'casefile_id' => 6, 'is_lead_investigator' => false, 'can_read_only' => true]

        ];
        foreach($assignedInvestigators as $aI){
            AssignedInvestigator::create($aI);
        }
    }
}

//$table->integer('user_id');
//$table->integer('casefile_id');
//$table->boolean('is_lead_investigator')->default(false);
//$table->boolean('can_read_only')->default(false);