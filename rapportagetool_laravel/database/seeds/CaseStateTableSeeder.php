<?php

use App\CaseState;
use Illuminate\Database\Seeder;

class CaseStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caseStates = [
            ['name' => 'Created',         'description' => '', 'style' => 'default','position' => 0,  'permission' => 0],
            ['name' => 'Reserved',        'description' => '', 'style' => 'default','position' => 1,  'permission' => 0],
            ['name' => 'Assigned',        'description' => '', 'style' => 'default','position' => 2,  'permission' => 0],
            ['name' => 'Intake',          'description' => '', 'style' => 'default','position' => 3,  'permission' => 0],
            ['name' => 'Proposal',        'description' => '', 'style' => 'default','position' => 4,  'permission' => 0],
            ['name' => 'Agreement',       'description' => '', 'style' => 'default','position' => 5,  'permission' => 0],
            ['name' => 'Down Payment',    'description' => '', 'style' => 'default','position' => 6,  'permission' => 0],
            ['name' => 'Planning',        'description' => '', 'style' => 'default','position' => 7,  'permission' => 0],
            ['name' => 'Active',          'description' => '', 'style' => 'default','position' => 8,  'permission' => 0],
            ['name' => 'On Hold',         'description' => '', 'style' => 'default','position' => 9,  'permission' => 0],
            ['name' => 'Report',          'description' => '', 'style' => 'default','position' => 10,  'permission' => 0],
            ['name' => 'Legal/Court',     'description' => '', 'style' => 'default','position' => 11,  'permission' => 0],
            ['name' => 'Invoice',         'description' => '', 'style' => 'default','position' => 12,  'permission' => 0],
            ['name' => 'Completed',       'description' => '', 'style' => 'default','position' => 13,  'permission' => 0],
            ['name' => 'Rejected',        'description' => '', 'style' => 'default','position' => 14,  'permission' => 0],
            ['name' => 'Cold',            'description' => '', 'style' => 'default','position' => 15,  'permission' => 0],
            ['name' => 'Payment Due',     'description' => '', 'style' => 'default','position' => 16,  'permission' => 0],
            ['name' => 'Inactive',        'description' => '', 'style' => 'default','position' => 17,  'permission' => 0],
            ['name' => 'Proposal Void',   'description' => '', 'style' => 'default','position' => 18,  'permission' => 0],
            ['name' => 'Deleted',         'description' => '', 'style' => 'default','position' => 19,  'permission' => 64]
        ];
        foreach($caseStates as $caseState){
            CaseState::create($caseState);
        }
    }
}
