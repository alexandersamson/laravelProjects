<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
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
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('behaviour')->nullable();
            $table->string('history')->nullable();
            $table->integer('parent_to_ids')->nullable();
            $table->integer('child_to_ids')->nullable();
            $table->integer('sibling_to_ids')->nullable();
            $table->integer('married_to_ids')->nullable();
            $table->integer('befriend_to_ids')->nullable();
            $table->integer('related_to_ids')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->integer('height')->nullable();
            $table->string('eyes')->nullable();
            $table->string('skin')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('occupation')->nullable();
            $table->integer('organization_id')->nullable();
            $table->string('email_work')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone_work')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_picture_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
