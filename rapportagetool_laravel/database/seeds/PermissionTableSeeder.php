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
            ['name' => 'Guest',             'description' => 'Can see/do nothing extra',            'bitwise_value' => 0],
            ['name' => 'Registered',        'description' => 'Can read blog posts',                 'bitwise_value' => 1],
            ['name' => 'Staff',             'description' => 'Can see users & can manage own blog', 'bitwise_value' => 2],
            ['name' => 'Investigator',      'description' => 'Can manage own cases & see clients',  'bitwise_value' => 4],
            ['name' => 'Moderator',         'description' => 'Can manage blog',                     'bitwise_value' => 8],
            ['name' => 'Finance',           'description' => 'Can manage invoicing',                'bitwise_value' => 16],
            ['name' => 'Relations',         'description' => 'Can manage clients',                  'bitwise_value' => 32],
            ['name' => 'Manager',           'description' => 'Can manage cases & assign roles',     'bitwise_value' => 64],
            ['name' => 'Administrator',     'description' => 'Can do technical/advanced things',    'bitwise_value' => 128],
            ['name' => 'Owner',             'description' => 'Can manage Managers/Administrators',  'bitwise_value' => 256]
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
