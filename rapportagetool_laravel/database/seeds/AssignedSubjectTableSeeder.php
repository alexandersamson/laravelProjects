<?php

use App\AssignedSubject;
use Illuminate\Database\Seeder;

class AssignedSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignedSubjects = [
            ['subject_id' => 1, 'casefile_id' => 1, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 2, 'casefile_id' => 2, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 3, 'casefile_id' => 3, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 1, 'casefile_id' => 4, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 2, 'casefile_id' => 5, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 3, 'casefile_id' => 6, 'can_read_only' => false, 'creator_id' => 1],
            ['subject_id' => 3, 'casefile_id' => 6, 'can_read_only' => false, 'creator_id' => 1]
        ];
        foreach($assignedSubjects as $aI){
            AssignedSubject::create($aI);
        }
    }
}
