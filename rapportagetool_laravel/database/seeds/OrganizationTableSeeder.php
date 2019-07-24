<?php

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = [
                ['name' => 'Detective For All',
                'email' => 'info@detectiveforall.nl',
                'phone' => '+31624539949',
                'city' => 'Vlaardingen',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0
             ],[
                'name' => 'Super Investigations',
                'email' => 'info@superinvestigations.nl',
                'phone' => '+316565656556',
                'city' => 'Den Haag',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0
            ],[
                'name' => 'Buurman en Buurman',
                'email' => 'info@detectiveforall.nl',
                'phone' => '+31612345678',
                'city' => 'Rotterdam',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0
            ],[
                'name' => 'NCME B.V.',
                'email' => 'info@ncme.nl',
                'phone' => '+3161464358',
                'city' => 'Amsterdam',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0
            ],
        ];

        foreach($organizations as $organization){
            Organization::create($organization);
        }
    }
}


//$table->bigIncrements('id');
//$table->timestamps();
//$table->integer('creator_id');
//$table->integer('modifier_id');
//$table->boolean('approved')->default(true);
//$table->dateTime('approved_at')->nullable();
//$table->integer('approved_by_id')->nullable();
//$table->string('name')->unique();
//$table->string('vat')->nullable();
//$table->string('coc')->nullable();
//$table->string('form')->nullable();
//$table->integer('ceo_id')->nullable();
//$table->integer('cfo_id')->nullable();
//$table->integer('coo_id')->nullable();
//$table->integer('cso_id')->nullable();
//$table->integer('cmo_id')->nullable();
//$table->integer('chr_id')->nullable();
//$table->integer('cpo_id')->nullable();
//$table->integer('clo_id')->nullable();
//$table->integer('cio_id')->nullable();
//$table->integer('cto_id')->nullable();
//$table->string('email')->nullable();
//$table->string('phone')->nullable();
//$table->string('address')->nullable();
//$table->string('postal_code')->nullable();
//$table->string('city')->nullable();
//$table->string('country')->nullable();
//$table->boolean('terminated')->default(false);
//$table->boolean('deleted')->default(false);
