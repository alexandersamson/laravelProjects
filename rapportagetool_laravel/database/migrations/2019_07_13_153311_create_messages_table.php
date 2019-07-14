<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
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
            $table->mediumText('body'); //is content
            $table->string('cover_image')->default('profilepicture/profilepicture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
