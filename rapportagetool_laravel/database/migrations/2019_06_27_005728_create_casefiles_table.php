<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasefilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casefiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('creator_id');
            $table->integer('modifier_id');
            $table->boolean('approved')->default(true);
            $table->dateTime('approved_at')->nullable();
            $table->integer('approval_by_id')->nullable();
            $table->string('casecode')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('case_state_index');
            $table->integer('lead_investigator_index');
            $table->integer('second_investigator_index')->nullable();
            $table->integer('client_index');
            $table->string('style')->default('default');
            $table->boolean('active')->default(1);
            $table->boolean('deleted')->default(false);
            $table->biginteger('permission')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casefiles');
    }
}
