<?php

use App\LinkCasefileCasenote;
use Illuminate\Database\Seeder;

class LinkCasefileCasenotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ccls = [
            [   'casefile_id' => 1,
                'casenote_id' => 1,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 1,
                'casenote_id' => 2,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 1,
                'casenote_id' => 3,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 1,
                'casenote_id' => 4,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 1,
                'casenote_id' => 5,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 2,
                'casenote_id' => 6,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],
            [   'casefile_id' => 2,
                'casenote_id' => 7,
                'creator_id' => 1,
                'modifier_id' => 1,
            ],


        ];
        foreach($ccls as $ccl){
            LinkCasefileCasenote::create($ccl);
        }
    }
}
