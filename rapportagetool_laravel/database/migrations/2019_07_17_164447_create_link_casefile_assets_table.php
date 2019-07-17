<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkCasefileAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_casefile_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('casefile_id');
            $table->integer('asset_id');
            $table->integer('creator_id');
            $table->integer('modifier_id')->nullable();
            $table->boolean('classified')->default(false);
            $table->boolean('permission')->default(0);
            $table->boolean('hidden')->default(false);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('link_casefile_assets');
    }
}
