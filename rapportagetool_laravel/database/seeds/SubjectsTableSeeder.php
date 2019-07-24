<?php

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'name' => 'Sammy Peters',
                'organization_id' => 1,
                'email' => 'sammy@peters.com',
                'phone' => '+31254565655',
                'phone_work' => '+31254565655',
                'description' => 'Sammy Peters is a very blunt man with a short temper',
                'gender' => 'man',
                'eyes' => 'blue',
                'skin' => 'licht',
                'height' => 175,
                'birthday' => '40-45 y/o',
                'city' => 'Den Haag',
                'country' => 'Nederland',
                'occupation' => 'Lawyer',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0,

            ],
            [
                'name' => 'Sander Pushin',
                'organization_id' => 1,
                'email' => 'sander@pushin.com',
                'phone' => '+31254565655',
                'phone_work' => '+31254565655',
                'description' => 'Sander P is een student aan de Hogeschool Rotterdam, 3e leerjaar. Opleiding onbekend.',
                'gender' => 'man',
                'eyes' => 'lichtbruin',
                'skin' => 'licht',
                'height' => 180,
                'birthday' => '20-25 y/o',
                'city' => 'Rotterdam',
                'country' => 'Nederland',
                'occupation' => 'Student',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0,
            ],
            [
                'name' => 'Sandra Petronella',
                'organization_id' => 1,
                'email' => 'sandra@petronella.com',
                'phone' => '+31254565655',
                'phone_work' => '+31254565655',
                'description' => 'Sandra is binnenhuisarchitect. Ze heeft in 2017 onderscheidingen ontvangen voor beste interrieur',
                'gender' => 'vrouw',
                'eyes' => 'donkerbruin',
                'skin' => 'donker',
                'height' => 170,
                'birthday' => '30-35 y/o',
                'city' => 'Rotterdam',
                'country' => 'Nederland',
                'occupation' => 'Binnenhuisarchitect',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0,
            ],
            [
                'name' => 'Samira Pijljaars',
                'organization_id' => 1,
                'email' => 'Samira@pijljaars.com',
                'phone' => '+31254565655',
                'phone_work' => '+31254565655',
                'description' => 'Samira is verloskundige in Haarlem',
                'gender' => 'vrouw',
                'eyes' => 'donkerbruin',
                'skin' => 'donker',
                'height' => 165,
                'birthday' => '30-35 y/o',
                'city' => 'Haarlem',
                'country' => 'Nederland',
                'occupation' => 'Verloskundige',
                'profile_picture_path' => 'profilepicture/profilepicture',
                'creator_id' => 1,
                'modifier_id' => 1,
                'permission' => 0,
            ]
        ];
        foreach($subjects as $subject){
            Subject::create($subject);
        }
    }

}

//$table->bigIncrements('id');
//$table->timestamps();
//$table->string('name');
//$table->string('description');
//$table->string('gender');
//$table->string('birthday');
//$table->string('height');
//$table->string('eyes');
//$table->string('skin');
//$table->string('address');
//$table->string('city');
//$table->string('postal_code');
//$table->string('country');
//$table->string('occupation');
//$table->integer('organization_id')->nullable();
//$table->string('email_work')->nullable();
//$table->string('email')->nullable()->unique();
//$table->string('phone_work')->nullable();
//$table->string('phone')->nullable();
//$table->string('profile_picture_path');
//$table->integer('user_id');
//$table->integer('modifier_id');
//$table->string('style')->default('default');
//$table->boolean('active')->default(1);
//$table->boolean('approved')->default(1);
//$table->boolean('deleted')->default(0);
//$table->biginteger('permission')->unsigned()->default(0);
