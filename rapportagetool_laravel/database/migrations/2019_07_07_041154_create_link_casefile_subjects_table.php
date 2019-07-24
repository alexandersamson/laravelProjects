<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkCasefileSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_casefile_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('subject_id');
            $table->integer('casefile_id');
            $table->boolean('can_read_only')->default(false);
            $table->boolean('is_prime_subject')->default(false);
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
        Schema::dropIfExists('link_casefile_subjects');
    }
}
