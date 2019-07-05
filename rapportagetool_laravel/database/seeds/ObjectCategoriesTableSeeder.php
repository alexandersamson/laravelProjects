<?php

use App\Http\Controllers\PermissionsController;
use App\ObjectCategory;
use App\Permission;
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
        $postPermissions = new PermissionsController();

        $objectCategories = [
            [   'name' => 'casefiles',
                'c_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'r_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
                'u_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'd_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
                'c_match_all' => false,
                'r_match_all' => false,
                'u_match_all' => false,
                'u_adv_match_all' => false,
                'd_match_all' => false,
                'r_by_creator' => false,
                'u_by_creator' => false,
                'u_adv_by_creator' => false,
                'd_by_creator' => false,
                'r_by_assigned_leader' => true,
                'u_by_assigned_leader' => true,
                'u_adv_by_assigned_leader' => true,
                'd_by_assigned_leader' => false,
                'r_by_assigned_user' => true,
                'u_by_assigned_user' => true,
                'u_adv_by_assigned_user' => false,
                'd_by_assigned_user' => false,
                'r_by_assigned_client' => true,
                'u_by_assigned_client' => false,
                'u_adv_by_assigned_client' => false,
                'd_by_assigned_client' => false
            ],
            [   'name' => 'users',
                'c_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'r_permission' => $postPermissions->getBitwiseValue(['Staff','Casemanager','Manager','Owner']),
                'u_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Owner']),
                'd_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
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
            [   'name' => 'clients',
                'c_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'r_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'u_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_permission' => $postPermissions->getBitwiseValue(['Relations']),
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
            [   'name' => 'organizations',
                'c_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'r_permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),
                'u_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Relations']),
                'd_permission' => $postPermissions->getBitwiseValue(['Relations']),
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
            [   'name' => 'posts',
                'c_permission' => $postPermissions->getBitwiseValue(['Staff','Moderator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Staff','Moderator','Investigator','Casemanager','Relations','Manager']),
                'u_permission' => $postPermissions->getBitwiseValue(['Moderator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Moderator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Moderator']),
                'c_match_all' => false,
                'r_match_all' => false,
                'u_match_all' => false,
                'u_adv_match_all' => false,
                'd_match_all' => false,
                'r_by_creator' => true,
                'u_by_creator' => true,
                'u_adv_by_creator' => false,
                'd_by_creator' => true,
                'r_by_assigned_user' => true
            ],
            [   'name' => 'settings',
                'c_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'r_permission' => $postPermissions->getBitwiseValue(['Manager','Owner']),
                'u_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'u_adv_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'd_permission' => $postPermissions->getBitwiseValue(['Administrator']),
                'c_match_all' => false,
                'r_match_all' => false,
                'u_match_all' => false,
                'u_adv_match_all' => false,
                'd_match_all' => false,
                'r_by_creator' => false,
                'u_by_creator' => false,
                'u_adv_by_creator' => false,
                'd_by_creator' => false],
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
