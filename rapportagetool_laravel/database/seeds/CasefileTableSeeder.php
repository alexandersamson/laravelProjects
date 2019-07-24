<?php

use App\Models\Casefile;
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
        $caseNumberD = $casenumberGenerator->generateCasefileCode();
        $caseNumberE = $casenumberGenerator->generateCasefileCode();
        $caseNumberF = $casenumberGenerator->generateCasefileCode();

        $casefiles = [
            [   'casecode' => $caseNumberA,
                'name' => 'Test Case [Auto generated]',
                'description' => 'This is an auto-generated casefile',
                'creator_id' => 1,
                'modifier_id' => 1,
                'approved' => 0,
                'case_state_index' => 1,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberB,
                'name' => 'Test Case 2 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'creator_id' => 1,
                'approved' => 0,
                'modifier_id' => 1,
                'case_state_index' => 2,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberC,
                'name' => 'Test Case 3 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'creator_id' => 1,
                'modifier_id' => 1,
                'case_state_index' => 3,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberD,
                'name' => 'Test Case 4 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'creator_id' => 1,
                'modifier_id' => 1,
                'case_state_index' => 4,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberE,
                'name' => 'Test Case 5 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'creator_id' => 1,
                'modifier_id' => 1,
                'case_state_index' => 5,
                'lead_investigator_index' => 1,
                'client_index' => 0,
                'style' => 'default',
                'permission' => 0],
            [   'casecode' => $caseNumberF,
                'name' => 'Test Case 6 [Auto generated]',
                'description' => 'This is an auto-generated casefile 3',
                'creator_id' => 1,
                'modifier_id' => 1,
                'case_state_index' => 6,
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
