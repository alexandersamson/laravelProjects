<?php

use App\Casefile;
use Illuminate\Database\Seeder;

class CasefileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Firstly generate a random Casefile Code
        $casenumberGenerator = new \App\Http\Controllers\Services\CasefileNumberGenerator();
        $caseNumberA = $casenumberGenerator->generateCasefileCode();
        $caseNumberB = $casenumberGenerator->generateCasefileCode();
        $caseNumberC = $casenumberGenerator->generateCasefileCode();

        $casefiles = [
            [   'casecode' => $caseNumberA,
                'name' => 'Test Case [Auto generated]',
                'description' => 'This is an auto-generated casefile',
                'user_id' => 1,
                'case_state_index' => 0,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberB,
                'name' => 'Test Case 2 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'user_id' => 1,
                'case_state_index' => 0,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberC,
                'name' => 'Test Case 3 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'user_id' => 1,
                'case_state_index' => 0,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
        ];
        foreach($casefiles as $casefile){
            Casefile::create($casefile);
        }
    }
}
