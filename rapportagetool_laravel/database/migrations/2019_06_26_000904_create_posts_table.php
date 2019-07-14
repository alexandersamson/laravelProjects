<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('creator_id');
            $table->integer('modifier_id');
            $table->boolean('approved')->default(true);
            $table->dateTime('approved_at')->nullable();
            $table->integer('approved_by_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('hidden')->default(false);
            $table->boolean('draft')->default(false);
            $table->boolean('deleted')->default(false);
            $table->integer('permission')->default(0);
            $table->string('style')->default('default');
            $table->string('name'); //is title
            $table->mediumText('body');
            $table->string('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
