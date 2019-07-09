<?php

use App\CaseState;
use App\Post;
use Illuminate\Database\Seeder;
use App\Http\Controllers\Services\PermissionsService;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postPermissions = new PermissionsService();
        $permissionSeed = $postPermissions->getBitwiseValue(['Staff','Moderator']);
        $posts = [
            ['name' => 'The first test post', 'body' => 'The fox jumps over the fence.', 'cover_image' => 'noimage.png', 'creator_id' => 1,  'modifier_id' => 1,  'permission' => $permissionSeed],
        ];
        foreach($posts as $post){
            Post::create($post);
        }
    }
}


//$table->string('title');
//$table->mediumText('body');
//$table->string('cover_image');
//$table->integer('user_id');
//$table->integer('modifier_id');
//$table->integer('permission');