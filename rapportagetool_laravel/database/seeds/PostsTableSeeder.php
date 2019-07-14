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
        $casecode = \App\Casefile::find(1)->casecode;
        $permissionSeed = $postPermissions->getBitwiseValue(['Staff','Moderator']);
        $posts = [
            ['name' => 'The first test post', 'body' => 'The [bold]big[/bold] [green]green[/green] fox jumps over the [red]red[/red] fence and falls in the [blue]blue[/blue] water. [cc]'.$casecode.'[/cc]
use [cc] to make links to casefiles.<br>
You can use [bold][bold][/bold], [blue][blue][/blue], [green][green][/green] and [red][red][/red] to spice things up a bit.', 'cover_image' => 'noimage.png', 'creator_id' => 1,  'modifier_id' => 1,  'permission' => $permissionSeed],
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