<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('creator_id');
            $table->integer('modifier_id');
            $table->boolean('approved')->default(true);
            $table->dateTime('approved_at')->nullable();
            $table->integer('approved_by_id')->nullable();;
            $table->integer('user_id');
            $table->string('organization_id')->nullable();
            $table->string('belongs_to')->default('user_id');
            $table->integer('permission')->default(0);
            $table->string('name');
            $table->string('description');
            $table->string('type');
            $table->string('number');
            $table->integer('issued_by_organization_id');
            $table->dateTime('valid_from')->default(Carbon::now());
            $table->dateTime('valid_to')->default(Carbon::now());
            $table->boolean('active')->default(true);
            $table->string('status')->default('in use');
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('licenses');
    }
}
