<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
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
            $table->string('name')->unique();
            $table->string('vat')->nullable();
            $table->string('coc')->nullable();
            $table->string('form')->nullable();
            $table->integer('ceo_id')->nullable();
            $table->integer('cfo_id')->nullable();
            $table->integer('coo_id')->nullable();
            $table->integer('cso_id')->nullable();
            $table->integer('cmo_id')->nullable();
            $table->integer('chr_id')->nullable();
            $table->integer('cpo_id')->nullable();
            $table->integer('clo_id')->nullable();
            $table->integer('cio_id')->nullable();
            $table->integer('cto_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('profile_picture_path');
            $table->boolean('terminated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
