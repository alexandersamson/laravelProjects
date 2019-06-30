<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'Registered',        'description' => 'Can log in',                          'bitwise_value' => 0],
            ['name' => 'Staff',             'description' => 'Can manage own posts & see users',    'bitwise_value' => 1],
            ['name' => 'Investigator',      'description' => 'Can partially manage assigned cases', 'bitwise_value' => 2],
            ['name' => 'Casemanager',       'description' => 'Can manage all cases & see clients',  'bitwise_value' => 4],
            ['name' => 'Moderator',         'description' => 'Can manage all posts',                'bitwise_value' => 8],
            ['name' => 'Finance',           'description' => 'Can manage all financial',            'bitwise_value' => 16],
            ['name' => 'Relations',         'description' => 'Can manage all clients',              'bitwise_value' => 32],
            ['name' => 'Manager',           'description' => 'Can manage most users',               'bitwise_value' => 64],
            ['name' => 'Administrator',     'description' => 'Can manage technical settings',       'bitwise_value' => 128],
            ['name' => 'Owner',             'description' => 'Can manage all users',                'bitwise_value' => 256]
        ];
        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}


//$table->bigInteger('bitwise-value')->unique();
//$table->string('name');
//$table->text('description')->nullable();
//$table->boolean('active')->default(1);
