<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkCasefileUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_casefile_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('casefile_id');
            $table->boolean('is_lead_investigator')->default(false);
            $table->boolean('can_read_only')->default(false);
            $table->integer('creator_id')->nullable();
            $table->integer('modifier_id')->nullable();
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_casefile_users');
    }
}
