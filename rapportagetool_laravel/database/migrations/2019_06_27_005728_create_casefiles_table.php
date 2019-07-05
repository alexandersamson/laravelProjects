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
            $table->string('casecode')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('user_id');
            $table->integer('modifier_id');
            $table->integer('case_state_index');
            $table->integer('lead_investigator_index');
            $table->integer('second_investigator_index')->nullable();
            $table->integer('client_index');
            $table->string('style')->default('default');
            $table->boolean('active')->default(1);
            $table->biginteger('permission')->unsigned()->default(0);
            $table->timestamps();
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
