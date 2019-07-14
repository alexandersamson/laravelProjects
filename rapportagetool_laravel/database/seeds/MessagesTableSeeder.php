<?php

use App\Message;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = [
            [   'name' => 'Message 1: Your first DM',
                'body' => 'Hey there! This is your first dm. [bold]Please ensure this text is bold[/bold]',
                'creator_id' => 1,
                'modifier_id' => 1,
            ],[   'name' => 'Message 2  From 2 to 1 and 3',
                'body' => 'Hey there! This is your first dm. [bold]Please ensure this text is bold[/bold]',
                'creator_id' => 2,
                'modifier_id' => 2,
            ],[   'name' => 'Message 3 From 2 to 3',
                'body' => 'Hey there! This is your first dm. [bold]Please ensure this text is bold[/bold]',
                'creator_id' => 2,
                'modifier_id' => 2,
            ],


        ];
        foreach($messages as $message){
            Message::create($message);
        }
    }
}


//$table->integer('creator_id');
//$table->integer('modifier_id');
//$table->boolean('approved')->default(true);
//$table->dateTime('approved_at')->nullable();
//$table->integer('approved_by_id')->nullable();
//$table->boolean('active')->default(true);
//$table->boolean('hidden')->default(false);
//$table->boolean('draft')->default(false);
//$table->boolean('deleted')->default(false);
//$table->integer('permission')->default(0);
//$table->string('style')->default('default');
//$table->string('name'); //is title
//$table->mediumText('body'); //is content
//$table->string('cover_image');