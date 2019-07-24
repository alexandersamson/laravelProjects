<?php

use App\Models\License;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LicensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $licenses = [
            [
                'name' => 'Vergunning POB1703',
                'description' => 'Vergunning van Justis',
                'creator_id' => 1,
                'modifier_id' => 1,
                'user_id' => 1,
                'organization_id' => 1,
                'belongs_to' => 'user_id',
                'type' => 'Vergunning POB',
                'number' => '201934435335',
                'issued_by_organization_id' => 1,
                'valid_from' => Carbon::now(),
                'valid_to' => Carbon::now()->addMonths(60),
                'profile_picture_path' => 'profilepicture/profilepicture'
            ],[
                'name' => 'Legitimatie Particulier Onderzoeker',
                'description' => 'De gele pas',
                'creator_id' => 1,
                'modifier_id' => 1,
                'user_id' => 1,
                'organization_id' => 1,
                'belongs_to' => 'user_id',
                'type' => 'Legitimatiebewijs P.O.',
                'number' => '12424546664',
                'issued_by_organization_id' => 1,
                'valid_from' => Carbon::now(),
                'valid_to' => Carbon::now()->addMonths(36),
                'profile_picture_path' => 'profilepicture/profilepicture'
            ],[
                'name' => 'Legitimatie Particulier Onderzoeker',
                'description' => 'De gele pas',
                'creator_id' => 1,
                'modifier_id' => 1,
                'user_id' => 4,
                'organization_id' => 1,
                'belongs_to' => 'user_id',
                'type' => 'Legitimatiebewijs P.O.',
                'number' => '646346648',
                'issued_by_organization_id' => 1,
                'valid_from' => Carbon::now(),
                'valid_to' => Carbon::now()->addMonths(12),
                'profile_picture_path' => 'profilepicture/profilepicture'
            ]
        ];
        foreach($licenses as $license){
            License::create($license);
        }
    }
}

//$table->bigIncrements('id');
//$table->timestamps();
//$table->integer('creator_id');
//$table->integer('modifier_id');
//$table->integer('user_id');
//$table->string('organization_id')->nullable();
//$table->string('belongs_to')->default('user_id');
//$table->string('name');
//$table->string('description');
//$table->string('type');
//$table->string('number');
//$table->integer('issued_by_organization_id');
//$table->date('valid_from')->default(now(date('YYYY-MM-DD')));
//$table->date('valid_to')->default(now(date('YYYY-MM-DD')));
//$table->boolean('active')->default(true);
//$table->string('status')->default('in use');
//$table->boolean('deleted')->default(false);
//$table->string('profile_picture_path');