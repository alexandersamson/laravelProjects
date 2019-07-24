<?php

use App\Http\Controllers\Services\PermissionsService;
use App\Models\ObjectCategory;
use Illuminate\Database\Seeder;

class ObjectCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postPermissions = new PermissionsService();

        $objectCategories = [
            [   'name' => 'casefiles',
                'c_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'r_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'u_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'd_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager','Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_match_all' => true,
                'r_by_creator' => true,
                'u_by_creator' => true, //Needed to edit own casfeiles
                'r_adv_by_creator' => true, //Needed to read own drafts
                'r_by_assigned_user' => true
            ],
            [   'name' => 'users',
                'c_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'r_permission' => $postPermissions->getBitwiseValue(['Staff','Casemanager','Manager','Owner']),
                'u_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'd_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'r_by_assigned_user' => true, //Needed to fully view one's own profile
                'r_adv_by_assigned_user' => true, //Needed to fully view one's own profile
            ],
            [   'name' => 'clients',
                'c_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'r_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'u_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Relations','Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_by_assigned_user' => true // for subjects, clients, licenses and posts
            ],
            [   'name' => 'subjects',
                'c_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'r_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'u_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'd_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager','Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_by_assigned_user' => true // for subjects, clients, licenses and posts
            ],
            [   'name' => 'organizations',
                'c_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'r_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'u_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'd_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Relations','Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
            ],
            [   'name' => 'posts',
                'c_permission' => $postPermissions->getBitwiseValue(['Staff','Moderator','Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Staff','Moderator','Investigator','Casemanager','Relations','Manager','Administrator']),
                'u_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Moderator','Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_by_creator' => true, //True for posts
                'u_by_creator' => true, //True for posts
                'd_by_creator' => true, //True for posts
                'r_by_assigned_user' => true // for subjects, clients, licenses and posts
            ],
            [   'name' => 'settings',
                'c_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Manager','Owner','Administrator']),
                'u_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_match_all' => false,
                'r_match_all' => false,
                'u_match_all' => false,
                'u_adv_match_all' => false,
                'd_match_all' => false,
                'r_by_creator' => false,
                'u_by_creator' => false,
                'u_adv_by_creator' => false,
                'd_by_creator' => false
            ],
            [   'name' => 'licenses',
                'c_permission' => $postPermissions->getBitwiseValue(['Manager']),
                'r_permission' => $postPermissions->getBitwiseValue(['Staff','Manager','Owner']),
                'u_permission' => $postPermissions->getBitwiseValue(['Manager']),
                'd_permission' => $postPermissions->getBitwiseValue(['Manager']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Manager','owner']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Manager','owner']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Manager','owner']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator','Manager','Owner']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_match_all' => false,
                'r_match_all' => false,
                'u_match_all' => false,
                'u_adv_match_all' => false,
                'd_match_all' => false,
                'r_by_creator' => false,
                'u_by_creator' => false,
                'r_adv_by_creator' => false,
                'u_adv_by_creator' => false,
                'd_by_creator' => false,
                'r_by_assigned_user' => true // for subjects, clients, licenses and posts
            ],
            [   'name' => 'messages',
                'c_permission' => $postPermissions->getBitwiseValue(['Staff','Investigator','Manager','Casemanager','Relations']),
                'r_permission' => $postPermissions->getBitwiseValue(['Registered','Staff','Investigator','Manager','Casemanager','Relations']),
                'u_permission' => $postPermissions->getBitwiseValue(['Staff','Investigator','Manager','Casemanager','Relations']),
                'd_permission' => $postPermissions->getBitwiseValue(['Staff','Investigator','Manager','Casemanager','Relations']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_by_creator' => true,
                'r_by_creator' => true,
                'u_by_creator' => true,
                'r_adv_by_creator' => true, //can read own messages
                'u_adv_by_creator' => true,
                'r_by_assigned_user' => true // for messages, subjects, clients, licenses and posts
            ],
            [   'name' => 'assets',
                'c_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_by_creator' => true,
                'r_by_creator' => true,
                'u_by_creator' => true,
                'r_adv_by_creator' => true,
                'u_adv_by_creator' => true,
            ],
            [   'name' => 'vehicles',
                'c_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_by_creator' => true,
                'r_by_creator' => true,
                'u_by_creator' => true,
                'r_adv_by_creator' => true,
                'u_adv_by_creator' => true,
            ],
            [   'name' => 'system_settings',
                'c_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_max_permission' => $postPermissions->getBitwiseValue(['Administrator']),
            ]
        ];

        foreach($objectCategories as $objectCategory){
            ObjectCategory::create($objectCategory);
        }
    }
}
//$table->string('name')->unique();
//$table->integer('c_permission');
//$table->integer('r_permission');
//$table->integer('u_permission');
//$table->integer('d_permission');
//$table->boolean('c_match_all')->default(true);
//$table->boolean('r_match_all')->default(true);
//$table->boolean('u_match_all')->default(true);
//$table->boolean('d_match_all')->default(true);
//$table->boolean('r_by_creator')->default(true);
//$table->boolean('u_by_creator')->default(false);
//$table->boolean('d_by_creator')->default(false);
//$table->boolean('r_by_assigned_leader')->default(false);
//$table->boolean('u_by_assigned_leader')->default(false);
//$table->boolean('r_by_assigned_user')->default(false);
//$table->boolean('u_by_assigned_user')->default(false);
//$table->boolean('r_by_assigned_client')->default(false);
//$table->boolean('u_by_assigned_client')->default(false);
