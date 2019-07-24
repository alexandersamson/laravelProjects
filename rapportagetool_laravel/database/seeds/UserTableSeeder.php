<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $users = [
            ['name' => 'Alexander Samson',
                'email' => 'alexander@gm7.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'city' => 'Vlaardingen',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 511
            ],
            ['name' => 'No Permission Testuser',
                'email' => 'alexander@gm6.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'city' => 'Rotterdam',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0
            ],
            ['name' => 'Staff Testuser',
                'email' => 'alexander@gm5.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'city' => 'Den Haag',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 1
            ],
            ['name' => 'Investigator Testuser',
                'email' => 'alexander@gm4.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 2
            ],
            ['name' => 'Staff/Investigator Testuser',
                'email' => 'alexander@gm3.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 3
            ],
            ['name' => 'Casemanager Testuser',
                'email' => 'alexander@gm2.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 5
            ],
            ['name' => 'Manager Testuser',
                'email' => 'alexander@gm1.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 65
            ],
            ['name' => 'Manager/Casemanager Testuser',
                'email' => 'alexander@gm0.nl',
                'password' => '$2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi',
                'phone' => '+31612345567',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 69
            ]

        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
//Password $2y$10$DRThKGB77vKlZiTCrDG4TOoxTFS5REjcQfmQd13WKoIyY3S4vmfwi = kippensoep