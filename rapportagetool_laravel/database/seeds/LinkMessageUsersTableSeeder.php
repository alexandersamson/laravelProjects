<?php

use App\Models\PivotLinks\LinkMessageUser;
use Illuminate\Database\Seeder;

class LinkMessageUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageUserLinks = [
            [   'user_id' => 1,
                'message_id' => 1,
                'creator_id' => 1,
                'modifier_id' => 1,
                'marked_as_read' => false,
            ],[ 'user_id' => 2,
                'message_id' => 1,
                'creator_id' => 1,
                'modifier_id' => 1,
                'marked_as_read' => false,
            ],[ 'user_id' => 1,
                'message_id' => 2,
                'creator_id' => 1,
                'modifier_id' => 1,
                'marked_as_read' => false,
            ],[ 'user_id' => 3,
                'message_id' => 2,
                'creator_id' => 1,
                'modifier_id' => 1,
                'marked_as_read' => false,
            ],[ 'user_id' => 3,
                'message_id' => 3,
                'creator_id' => 1,
                'modifier_id' => 1,
                'marked_as_read' => false,
            ],


        ];
        foreach($messageUserLinks as $messageUserLink){
            LinkMessageUser::create($messageUserLink);
        }
    }
}

//$table->integer('user_id');
//$table->integer('message_id');
//$table->boolean('marked_as_read')->default(false);
//$table->integer('creator_id')->nullable();
//$table->integer('modifier_id')->nullable();
//$table->boolean('hidden')->default(false);
//$table->boolean('active')->default(true);
//$table->boolean('deleted')->default(false);